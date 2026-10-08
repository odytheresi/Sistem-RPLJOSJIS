<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            ['id_role' => 1, 'nma_role' => 'admin'],
            ['id_role' => 2, 'nma_role' => 'operator'],
            ['id_role' => 3, 'nma_role' => 'pengemudi'],
        ]);
    }
}