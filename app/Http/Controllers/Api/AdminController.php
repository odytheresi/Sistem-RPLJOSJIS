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

    public function ubahRoleUser(Request $request, $id): JsonResponse
    {
        $data = $request->validate(['id_role' => 'required|exists:role,id_role']);

        if ((int) $id === $request->user()->id_user) {
            return response()->json(['message' => 'Tidak bisa mengubah role akun sendiri.'], 422);
        }

        DB::table('user')->where('id_user', $id)->update([
            'id_role'    => $data['id_role'],
            'updated_at' => now(),
        ]);

        $this->catat($request, 'ubah_role_user', 'User', $id, 'id_role menjadi ' . $data['id_role']);

        return response()->json(['message' => 'Role akun diperbarui.']);
    }

    // ---------- hak akses ----------
    public function role(): JsonResponse
    {
        return response()->json(Role::all());
    }

    public function hakAksesRole($id): JsonResponse
    {
        $punya = HakAkses::where('id_role', $id)->get()->keyBy('nm_fitur');

        return response()->json(
            HakAkses::distinct()->pluck('nm_fitur')->map(fn ($f) => [
                'nm_fitur' => $f,
                'lihat'    => (bool) ($punya[$f]->lihat ?? false),
                'tambah'   => (bool) ($punya[$f]->tambah ?? false),
                'ubah'     => (bool) ($punya[$f]->ubah ?? false),
                'hapus'    => (bool) ($punya[$f]->hapus ?? false),
            ])->values()
        );
    }

    public function simpanHakAkses(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'akses'            => 'required|array',
            'akses.*.nm_fitur' => 'required|string',
        ]);

        foreach ($data['akses'] as $a) {
            HakAkses::updateOrCreate(
                ['id_role' => $id, 'nm_fitur' => $a['nm_fitur']],
                [
                    'lihat'  => (bool) ($a['lihat'] ?? false),
                    'tambah' => (bool) ($a['tambah'] ?? false),
                    'ubah'   => (bool) ($a['ubah'] ?? false),
                    'hapus'  => (bool) ($a['hapus'] ?? false),
                ]
            );
        }

        $this->catat($request, 'ubah_hak_akses', 'Role', $id);

        return response()->json(['message' => 'Hak akses disimpan.']);
    }

    public function ubahStatusRole(Request $request, $id): JsonResponse
    {
        $data = $request->validate(['status' => 'required|in:aktif,nonaktif']);

        $role = Role::findOrFail($id);
        if ($role->nma_role === 'admin' && $data['status'] === 'nonaktif') {
            return response()->json(['message' => 'Role admin tidak boleh dinonaktifkan.'], 422);
        }

        DB::table('role')->where('id_role', $id)->update(['status' => $data['status']]);

        $this->catat($request, 'ubah_status_role', 'Role', $id, 'Status menjadi ' . $data['status']);

        return response()->json(['message' => 'Status role diperbarui.']);
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