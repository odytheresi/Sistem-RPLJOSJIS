<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->upsert([
            ['nma_role' => 'admin',     'status' => 'aktif'],
            ['nma_role' => 'operator',  'status' => 'aktif'],
            ['nma_role' => 'pengemudi', 'status' => 'aktif'],
        ], ['nma_role'], ['status']);
    }
}