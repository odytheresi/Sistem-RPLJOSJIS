<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonfigSistemSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('konfig_sistem')->upsert([
            ['nm_konfig' => 'nama_aplikasi',        'nilai' => 'Admin RPL', 'deskripsi' => 'Nama yang tampil di header',      'created_at' => $now, 'updated_at' => $now],
            ['nm_konfig' => 'timeout_sesi_menit',   'nilai' => '10',        'deskripsi' => 'Batas sesi tidak aktif (menit)',  'created_at' => $now, 'updated_at' => $now],
            ['nm_konfig' => 'maks_percobaan_login', 'nilai' => '5',         'deskripsi' => 'Maksimal percobaan login gagal',  'created_at' => $now, 'updated_at' => $now],
            ['nm_konfig' => 'mode_pemeliharaan',    'nilai' => '0',         'deskripsi' => '1 = aktif, 0 = nonaktif',         'created_at' => $now, 'updated_at' => $now],
        ], ['nm_konfig'], ['deskripsi', 'updated_at']); // nilai tidak ditimpa kalau seeder dijalankan ulang
    }
}