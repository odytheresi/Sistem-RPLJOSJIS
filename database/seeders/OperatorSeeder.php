<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'operator@test.com'],
            [
                'name'       => 'Operator Tes',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $idUser = DB::table('users')
            ->where('email', 'operator@test.com')
            ->value('id');

        DB::table('operator')->updateOrInsert(
            ['id_user' => $idUser],
            [
                'nama_operator' => 'Operator Tes',
                'no_hp'         => '081234567890',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }
}