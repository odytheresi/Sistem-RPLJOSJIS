<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // identifier => nama admin
        $admins = [
            'AN001' => 'Budi Yono',
            'AN002' => 'Siti Rahma',
        ];

        $idUser = DB::table('user')
            ->whereIn('identifier', array_keys($admins))
            ->pluck('id_user', 'identifier');

        $now  = now();
        $rows = [];

        foreach ($admins as $identifier => $nama) {
            $rows[] = [
                'id_user'    => $idUser[$identifier],
                'nm_admin'   => $nama,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('admin')->upsert($rows, ['id_user'], ['nm_admin', 'updated_at']);
    }
}