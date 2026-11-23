<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HakAkses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeController extends Controller
{
    // Meratakan kolom lihat/tambah/ubah/hapus menjadi baris {nm_fitur, aksi}
    public function hakAkses(Request $request): JsonResponse
    {
        $hasil = [];

        foreach (HakAkses::where('id_role', $request->user()->id_role)->get() as $row) {
            foreach (['lihat', 'tambah', 'ubah', 'hapus'] as $aksi) {
                if ($row->$aksi) {
                    $hasil[] = ['nm_fitur' => $row->nm_fitur, 'aksi' => $aksi];
                }
            }
        }

        return response()->json($hasil);
    }
}