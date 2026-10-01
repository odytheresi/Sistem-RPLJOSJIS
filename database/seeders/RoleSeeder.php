<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'id_role' => 1,
                'nma_role' => 'Admin',
            ],
            [
                'id_role' => 2,
                'nma_role' => 'Operator',
            ],
            [
                'id_role' => 3,
                'nma_role' => 'Pengemudi',
            ],
        ]);
    }
}