<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $role = DB::table('role')->pluck('id_role', 'nma_role');
        $now  = now();

        DB::table('user')->upsert([
            [
                'id_role'    => $role['admin'],
                'identifier' => 'AN001',
                'password'   => Hash::make('password123'),
                'status'     => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role'    => $role['admin'],
                'identifier' => 'AN002',
                'password'   => Hash::make('password123'),
                'status'     => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role'    => $role['operator'],
                'identifier' => 'OP001',
                'password'   => Hash::make('password123'),
                'status'     => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_role'    => $role['pengemudi'],
                'identifier' => 'rafael',
                'password'   => Hash::make('password123'),
                'status'     => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['identifier'], ['id_role', 'status', 'updated_at']);
    }
}