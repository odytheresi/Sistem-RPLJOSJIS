<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        $idUser = DB::table('user')->where('identifier', 'OP001')->value('id_user');

        DB::table('operator')->updateOrInsert(
            ['id_user' => $idUser],
            ['nama_operator' => 'Amanjiwo', 'no_hp' => '081234567890',
             'created_at' => now(), 'updated_at' => now()]
        );
    }
}