<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengemudiSeeder extends Seeder
{
    public function run(): void
    {
        // username (identifier) => [nama, email, no_hp]
        $pengemudi = [
            'rafael' => ['Rafael', 'rafael@gmail.com', '081234567890'],
        ];

        $idUser = DB::table('user')
            ->whereIn('identifier', array_keys($pengemudi))
            ->pluck('id_user', 'identifier');

        $now  = now();
        $rows = [];

        foreach ($pengemudi as $identifier => [$nama, $email, $noHp]) {
            $rows[] = [
                'id_user'      => $idUser[$identifier],
                'nm_pengemudi' => $nama,
                'email'        => $email,
                'no_hp'        => $noHp,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        DB::table('pengemudi')->upsert(
            $rows,
            ['id_user'],
            ['nm_pengemudi', 'email', 'no_hp', 'updated_at']
        );
    }
}