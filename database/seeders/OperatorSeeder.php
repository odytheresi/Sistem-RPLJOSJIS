<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        // identifier => [nama, no_hp]
        $operators = [
            'OP001' => ['Amanjiwo',       '081234567890'],
            'OP002' => ['Hendra Saputra', '081234567891'],
            'OP003' => ['Maya Lestari',   '081234567892'],
            'OP004' => ['Fajar Nugroho',  '081234567893'],
        ];

        $idUser = DB::table('user')
            ->whereIn('identifier', array_keys($operators))
            ->pluck('id_user', 'identifier');

        foreach ($operators as $identifier => [$nama, $hp]) {
            DB::table('operator')->updateOrInsert(
                ['id_user' => $idUser[$identifier]],
                ['nama_operator' => $nama, 'no_hp' => $hp,
                 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}