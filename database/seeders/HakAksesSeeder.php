<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HakAksesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('role')
            ->pluck('id_role', 'nma_role');

        $data = [
            // =========================
            // ADMIN
            // =========================
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'dashboard',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'manajemen_user',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'role_hak_akses',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'konfigurasi_sistem',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'audit_log',
                'lihat' => true,
                'tambah' => false,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'operator',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'pengemudi',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'charging_station',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'charger',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'tarif',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'perbaikan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'kendaraan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'sesi_charge',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'transaksi',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'keluhan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['admin'],
                'nm_fitur' => 'notifikasi',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],

            // =========================
            // OPERATOR
            // =========================
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'dashboard',
                'lihat' => true,
                'tambah' => false,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'charging_station',
                'lihat' => true,
                'tambah' => false,
                'ubah' => true,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'charger',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'tarif',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'perbaikan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'keluhan',
                'lihat' => true,
                'tambah' => false,
                'ubah' => true,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['operator'],
                'nm_fitur' => 'notifikasi',
                'lihat' => true,
                'tambah' => false,
                'ubah' => false,
                'hapus' => false,
            ],

            // =========================
            // PENGEMUDI
            // =========================
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'dashboard',
                'lihat' => true,
                'tambah' => false,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'kendaraan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => true,
                'hapus' => true,
            ],
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'sesi_charge',
                'lihat' => true,
                'tambah' => true,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'transaksi',
                'lihat' => true,
                'tambah' => true,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'keluhan',
                'lihat' => true,
                'tambah' => true,
                'ubah' => false,
                'hapus' => false,
            ],
            [
                'id_role' => $roles['pengemudi'],
                'nm_fitur' => 'notifikasi',
                'lihat' => true,
                'tambah' => false,
                'ubah' => false,
                'hapus' => false,
            ],
        ];

        foreach ($data as $akses) {
            DB::table('hak_akses')->updateOrInsert(
                [
                    'id_role' => $akses['id_role'],
                    'nm_fitur' => $akses['nm_fitur'],
                ],
                [
                    'lihat' => $akses['lihat'],
                    'tambah' => $akses['tambah'],
                    'ubah' => $akses['ubah'],
                    'hapus' => $akses['hapus'],
                ]
            );
        }
    }
}