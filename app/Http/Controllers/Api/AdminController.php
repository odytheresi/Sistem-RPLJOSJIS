<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audit_Log;
use App\Models\HakAkses;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // FR-13: satu pintu untuk mencatat aktivitas penting
    private function catat(Request $r, string $aktivitas, string $entitas, $idRef, ?string $ket = null): void
    {
        Audit_Log::create([
            'id_user'         => $r->user()->id_user,
            'aktivitas'       => $aktivitas,
            'entitas_terkait' => $entitas,
            'id_referensi'    => (string) $idRef,
            'keterangan'      => $ket,
        ]);
    }

    // ---------- Dashboard ----------
    public function ringkasan(): JsonResponse
{
    return response()->json([
        'total_user'         => User::count(),
        'user_aktif'         => User::where('status', 'aktif')->count(),
        'total_role'         => Role::count(),
        'aktivitas_hari_ini' => Audit_Log::whereDate('waktu', today())->count(),
        'user_per_role'      => Role::withCount('users')->get()
            ->map(fn ($r) => ['role' => $r->nma_role, 'total' => $r->users_count]),
        'log_terbaru'        => Audit_Log::with('user')->latest('waktu')->limit(5)->get(),
    ]);
}

    // ---------- Manajemen user ----------
    public function user(): JsonResponse
    {
        return response()->json(User::with('role')->get());
    }

    public function ubahStatusUser(Request $request, $id): JsonResponse
    {
        $data   = $request->validate(['status' => 'required|in:aktif,nonaktif']);
        $target = User::with('role')->findOrFail($id);

        if ($data['status'] === 'nonaktif') {
            if ((int) $id === $request->user()->id_user) {
                return response()->json(['message' => 'Tidak bisa menonaktifkan akun sendiri.'], 422);
            }

            // minimal harus ada 1 admin aktif
            if ($target->role?->nma_role === 'admin') {
                $adminAktif = User::where('status', 'aktif')
                    ->whereHas('role', fn ($q) => $q->where('nma_role', 'admin'))->count();
                if ($adminAktif <= 1) {
                    return response()->json(['message' => 'Admin aktif terakhir tidak boleh dinonaktifkan.'], 422);
                }
            }
        }

        DB::table('user')->where('id_user', $id)->update([
            'status'     => $data['status'],
            'updated_at' => now(),
        ]);

        // paksa logout akun yang dinonaktifkan (Sanctum)
        if ($data['status'] === 'nonaktif') {
            $target->tokens()->delete();
        }

        $this->catat($request, $data['status'] === 'aktif' ? 'aktifkan_user' : 'nonaktifkan_user', 'User', $id);

        return response()->json(['message' => 'Status akun diperbarui.']);
    }


    // ---------- Laporan ----------
    private function dataLaporan(Request $request): array
        {
            $request->validate([
                'dari'   => 'nullable|date',
                'sampai' => 'nullable|date|after_or_equal:dari',
            ]);

            // FR-07: default periode 3 bulan terakhir
            $dari   = $request->input('dari', now()->subMonths(3)->toDateString());
            $sampai = $request->input('sampai', today()->toDateString());

            $awal  = Carbon::parse($dari)->startOfDay();
            $akhir = Carbon::parse($sampai)->endOfDay();

            // ===== 1. Sesi charging per bulan (tunggu tabel dari pengemudi) =====
            $sesiPerBulan = collect();
            if (Schema::hasTable('sesi_charging')) {
                $sesiPerBulan = DB::table('sesi_charging')
                    ->whereBetween('waktu_mulai', [$awal, $akhir])
                    ->select(
                        DB::raw("DATE_FORMAT(waktu_mulai, '%Y-%m') as bulan"),
                        DB::raw('COUNT(*) as jumlah_sesi'),
                        DB::raw('COALESCE(SUM(energi_kwh), 0) as total_kwh')
                    )
                    ->groupBy('bulan')->orderBy('bulan')->get();
            }

            // ===== 2. Pendapatan per stasiun (tunggu tabel dari pengemudi) =====
            $pendapatan = collect();
            if (Schema::hasTable('transaksi') && Schema::hasTable('sesi_charging')) {
                $pendapatan = DB::table('transaksi as t')
                    ->join('sesi_charging as s', 's.id_sesi', '=', 't.id_sesi')
                    ->join('charger as c', 'c.id_charger', '=', 's.id_charger')
                    ->join('charging_station as st', 'st.id_stasiun', '=', 'c.id_stasiun')
                    ->where('t.status', 'berhasil')
                    ->whereBetween('t.waktu_bayar', [$awal, $akhir])
                    ->select(
                        'st.nama_stasiun as stasiun',
                        DB::raw('COUNT(t.id_transaksi) as jumlah_transaksi'),
                        DB::raw('SUM(t.jumlah) as total_pendapatan')
                    )
                    ->groupBy('st.id_stasiun', 'st.nama_stasiun')
                    ->orderByDesc('total_pendapatan')->get();
            }

            // ===== 3. Riwayat kerusakan charger (bisa jalan sekarang) =====
            $kerusakan = collect();
            if (Schema::hasTable('gangguan')) {
                $kerusakan = DB::table('gangguan as g')
                    ->join('charger as c', 'c.id_charger', '=', 'g.id_charger')
                    ->join('charging_station as st', 'st.id_stasiun', '=', 'c.id_stasiun')
                    ->whereBetween('g.waktu_lapor', [$awal, $akhir])
                    ->select(
                        'st.nama_stasiun as stasiun',
                        'c.kode_charger as charger',
                        'g.deskripsi', 'g.waktu_lapor', 'g.waktu_selesai', 'g.status',
                        DB::raw('TIMESTAMPDIFF(HOUR, g.waktu_lapor, COALESCE(g.waktu_selesai, NOW())) as durasi_jam')
                    )
                    ->orderByDesc('g.waktu_lapor')->get();
            }

            // ===== 4. Aktivitas sistem (laporan lama kamu) =====
            $log = fn () => Audit_Log::whereBetween('waktu', [$awal, $akhir]);

            return [
                'periode'                => compact('dari', 'sampai'),

                'sesi_per_bulan'         => $sesiPerBulan,
                'pendapatan_per_stasiun' => $pendapatan,
                'total_pendapatan'       => (float) $pendapatan->sum('total_pendapatan'),
                'kerusakan'              => $kerusakan,

                'total_aktivitas' => $log()->count(),
                'per_aktivitas'   => $log()->select('aktivitas', DB::raw('count(*) as total'))
                                        ->groupBy('aktivitas')->orderByDesc('total')->get(),
                'per_hari'        => $log()->select(DB::raw('DATE(waktu) as tanggal'), DB::raw('count(*) as total'))
                                        ->groupBy('tanggal')->orderBy('tanggal')->get(),
                'user_teraktif'   => $log()->select('id_user', DB::raw('count(*) as total'))
                                        ->groupBy('id_user')->with('user:id_user,identifier')
                                        ->orderByDesc('total')->limit(10)->get(),
            ];
        }
    // Untuk tampilan di layar (JSON)
    public function laporan(Request $request): JsonResponse
    {
        return response()->json($this->dataLaporan($request));
    }

    // Untuk unduhan PDF
    public function laporanPdf(Request $request)
    {
        $request->validate([
            'dari'   => 'required|date',
            'sampai' => 'required|date|after_or_equal:dari',
        ]);

        $data = $this->dataLaporan($request);

        $this->catat($request, 'ekspor_laporan', 'Laporan', $request->dari . '_' . $request->sampai);

        return Pdf::loadView('admin.laporan_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->download("laporan-aktivitas-{$request->dari}-{$request->sampai}.pdf");
    }
    

    // ---------- Audit log (FR-13) ----------
    public function auditLog(Request $request): JsonResponse
    {
        $q = Audit_Log::with('user')->latest('waktu');

        if ($request->filled('user')) {
            $q->whereHas('user', fn ($u) =>
                $u->where('identifier', 'like', '%' . $request->user . '%'));
        }
        if ($request->filled('aktivitas')) {
            $q->where('aktivitas', $request->aktivitas);
        }
        if ($request->filled('dari')) {
            $q->whereDate('waktu', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $q->whereDate('waktu', '<=', $request->sampai);
        }
        if ($request->filled('tanggal')) {
            $q->whereDate('waktu', $request->tanggal);
        }   

        return response()->json($q->paginate(20));
    }

}