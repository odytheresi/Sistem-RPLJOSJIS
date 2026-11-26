<?php

namespace Database\Seeders;

use App\Models\TipeKonektor;
use Illuminate\Database\Seeder;

class TipeKonektorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // AC: dipakai di charger 7 - 22 kW
            ['nama_konektor' => 'Type 2',  'jenis_charging' => 'AC Type 2'],
            // DC: dipakai di fast charging 50 - 150 kW
            ['nama_konektor' => 'CCS2',    'jenis_charging' => 'DC Fast Charging'],
            ['nama_konektor' => 'CHAdeMO', 'jenis_charging' => 'DC Fast Charging'],
        ];

        foreach ($data as $row) {
            TipeKonektor::updateOrCreate(
                ['nama_konektor' => $row['nama_konektor']],
                ['jenis_charging' => $row['jenis_charging']]
            );
        }
    }
}