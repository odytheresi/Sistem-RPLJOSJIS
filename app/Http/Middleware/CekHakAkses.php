<?php

namespace App\Http\Middleware;

use App\Models\HakAkses;
use Closure;
use Illuminate\Http\Request;

// Pemakaian: ->middleware('akses:nm_fitur,lihat|tambah|ubah|hapus')
class CekHakAkses
{
    public function handle(Request $request, Closure $next, string $fitur, string $aksi)
    {
        $user = $request->user();

        $boleh = $user
            && $user->status === 'aktif'
            && HakAkses::where('id_role', $user->id_role)
                ->where('nm_fitur', $fitur)
                ->where($aksi, true)
                ->exists();

        abort_unless($boleh, 403, 'Tidak punya hak akses.');

        return $next($request);
    }
}