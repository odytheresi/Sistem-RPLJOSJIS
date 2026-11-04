<?php

namespace App\Http\Middleware;

use App\Models\HakAkses;
use Closure;
use Illuminate\Http\Request;

// Pemakaian: ->middleware('akses:nm_fitur,aksi')  contoh: 'akses:audit_log,lihat'
class CekHakAkses
{
    private const AKSI = ['lihat', 'tambah', 'ubah', 'hapus'];

    public function handle(Request $request, Closure $next, string $fitur, string $aksi)
    {
        if (! in_array($aksi, self::AKSI, true)) {
            throw new \InvalidArgumentException("Aksi '$aksi' tidak dikenal.");
        }

        $user = $request->user();

        $boleh = $user
            && $user->status === 'aktif'
            && $user->role?->status === 'aktif'      // role yang dinonaktifkan langsung kehilangan akses
            && HakAkses::where('id_role', $user->id_role)
                ->where('nm_fitur', $fitur)
                ->where($aksi, true)
                ->exists();

        abort_unless($boleh, 403, 'Tidak punya hak akses.');

        return $next($request);
    }
}