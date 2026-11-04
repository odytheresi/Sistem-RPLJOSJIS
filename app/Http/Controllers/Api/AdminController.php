<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audit_Log;
use App\Models\HakAkses;
// use App\Models\Notifikasi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return response()->json($q->paginate(20));
    }
}