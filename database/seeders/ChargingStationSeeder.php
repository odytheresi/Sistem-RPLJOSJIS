<?php

namespace Database\Seeders;

use App\Models\Charger;
use App\Models\ChargingStation;
use App\Models\Operator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Seeder charging station + charger area Yogyakarta & sekitarnya.
 *
 * Prasyarat: tabel `operator` sudah punya minimal 1 data
 * (jalankan seeder user/operator lebih dulu).
 *
 * Idempotent: station dicocokkan lewat nama_st, charger lewat kd_charger,
 * jadi aman dijalankan berulang.
 *
 * Catatan daya (kW) agar realistis:
 *  - Type 2 (AC)  : 7 / 11 / 22 kW  -> charger lambat/menengah di mall, kampus, wisata
 *  - CCS2 (DC)    : 50 / 60 / 120 / 150 kW -> fast charging di lokasi singgah (bandara, mall besar)
 *  - CHAdeMO (DC) : 50 kW -> standar lama, masih dipakai beberapa mobil (mis. Nissan Leaf)
 */
class ChargingStationSeeder extends Seeder
{
    public function run(): void
    {
        $operators = Operator::orderBy('id_operator')->get();

        if ($operators->isEmpty()) {
            $this->command?->error('Belum ada data operator. Seed user & operator dulu.');
            return;
        }

        $konektor = $this->seedTipeKonektor();

        foreach ($this->data() as $i => $s) {
            $operator = $operators[$i % $operators->count()];

            $station = ChargingStation::updateOrCreate(
                ['nama_st' => $s['nama']],
                [
                    'id_operator' => $operator->id_operator,
                    'alamat'      => $s['alamat'],
                    'latitude'    => $s['lat'],
                    'longitude'   => $s['lng'],
                    'status'      => $s['status'],
                ]
            );

            foreach ($s['chargers'] as $n => [$tipe, $daya, $status]) {
                $kode = sprintf('%s-%s%02d', $s['kode'], $tipe === 'Type 2' ? 'AC' : 'DC', $n + 1);

                Charger::updateOrCreate(
                    ['kd_charger' => $kode],
                    [
                        'id_station'  => $station->id_station,
                        'id_konektor' => $konektor[$tipe],
                        'daya_maks'   => $daya,
                        'status'      => $status,
                    ]
                );
            }
        }
    }

    /**
     * Pastikan tipe konektor ada, return map [nama => id_konektor].
     * Nama kolom dideteksi otomatis (nama_konektor / nm_konektor).
     */
    private function seedTipeKonektor(): array
    {
        $col = Schema::hasColumn('tipe_konektor', 'nama_konektor') ? 'nama_konektor' : 'nm_konektor';

        $map = [];
        foreach (['Type 2', 'CCS2', 'CHAdeMO'] as $nama) {
            $row = DB::table('tipe_konektor')->where($col, $nama)->first();

            $map[$nama] = $row
                ? $row->id_konektor
                : DB::table('tipe_konektor')->insertGetId([$col => $nama], 'id_konektor');
        }

        return $map;
    }

    /**
     * Format charger: [tipe konektor, daya_maks kW, status]
     * Status station: aktif | nonaktif | maintenance
     * Status charger: tersedia | digunakan | error | perbaikan
     */
    private function data(): array
    {
        return [
            [
                'kode'   => 'YGY-TGU',
                'nama'   => 'SPKLU Stasiun Tugu Yogyakarta',
                'alamat' => 'Jl. Pangeran Mangkubumi No.1, Gedongtengen, Kota Yogyakarta, DIY',
                'lat'    => -7.78930000, 'lng' => 110.36260000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2', 22, 'tersedia'],
                    ['Type 2', 22, 'digunakan'],
                    ['CCS2',   50, 'tersedia'],
                ],
            ],
            [
                'kode'   => 'YGY-MLB',
                'nama'   => 'Charging Station Malioboro Mall',
                'alamat' => 'Jl. Malioboro No.52-58, Suryatmajan, Danurejan, Kota Yogyakarta, DIY',
                'lat'    => -7.78350000, 'lng' => 110.36550000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2', 7,  'tersedia'],
                    ['Type 2', 7,  'digunakan'],
                    ['CCS2',   60, 'tersedia'],
                ],
            ],
            [
                'kode'   => 'SLM-AMB',
                'nama'   => 'Charging Station Ambarrukmo Plaza',
                'alamat' => 'Jl. Laksda Adisucipto No.80, Caturtunggal, Depok, Sleman, DIY',
                'lat'    => -7.78300000, 'lng' => 110.40110000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2',  11,  'tersedia'],
                    ['Type 2',  11,  'tersedia'],
                    ['CCS2',    120, 'digunakan'],
                    ['CHAdeMO', 50,  'tersedia'],
                ],
            ],
            [
                'kode'   => 'SLM-HTN',
                'nama'   => 'Charging Station Hartono Mall Yogyakarta',
                'alamat' => 'Jl. Ring Road Utara, Condongcatur, Depok, Sleman, DIY',
                'lat'    => -7.75890000, 'lng' => 110.40970000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2', 22, 'tersedia'],
                    ['Type 2', 22, 'tersedia'],
                    ['CCS2',   60, 'tersedia'],
                ],
            ],
            [
                'kode'   => 'SLM-JCM',
                'nama'   => 'Charging Station Jogja City Mall',
                'alamat' => 'Jl. Magelang Km 6, Sinduadi, Mlati, Sleman, DIY',
                'lat'    => -7.75030000, 'lng' => 110.35960000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2', 7,  'tersedia'],
                    ['CCS2',   50, 'error'],
                ],
            ],
            [
                'kode'   => 'SLM-UGM',
                'nama'   => 'Charging Station Kampus UGM Bulaksumur',
                'alamat' => 'Jl. Bulaksumur, Caturtunggal, Depok, Sleman, DIY',
                'lat'    => -7.77130000, 'lng' => 110.37750000,
                'status' => 'aktif',
                'chargers' => [
                    ['Type 2', 7,  'tersedia'],
                    ['Type 2', 7,  'digunakan'],
                    ['Type 2', 22, 'tersedia'],
                ],
            ],
            [
                'kode'   => 'KLP-YIA',
                'nama'   => 'SPKLU Bandara Internasional Yogyakarta (YIA)',
                'alamat' => 'Palihan, Temon, Kulon Progo, DIY',
                'lat'    => -7.90070000, 'lng' => 110.05730000,
                'status' => 'aktif',
                'chargers' => [
                    ['CCS2',   150, 'tersedia'],
                    ['CCS2',   150, 'digunakan'],
                    ['CCS2',   60,  'tersedia'],
                    ['Type 2', 22,  'tersedia'],
                ],
            ],
            [
                'kode'   => 'SLM-PRB',
                'nama'   => 'Charging Station Kawasan Candi Prambanan',
                'alamat' => 'Jl. Raya Solo - Yogyakarta Km 16, Bokoharjo, Prambanan, Sleman, DIY',
                'lat'    => -7.75200000, 'lng' => 110.49150000,
                'status' => 'maintenance',
                'chargers' => [
                    ['Type 2', 22, 'perbaikan'],
                    ['Type 2', 22, 'perbaikan'],
                    ['CCS2',   50, 'perbaikan'],
                ],
            ],
            [
                'kode'   => 'SLM-KLU',
                'nama'   => 'Charging Station Wisata Kaliurang',
                'alamat' => 'Jl. Kaliurang Km 25, Hargobinangun, Pakem, Sleman, DIY',
                'lat'    => -7.61000000, 'lng' => 110.42600000,
                'status' => 'nonaktif',
                'chargers' => [
                    ['Type 2', 7, 'error'],
                ],
            ],
        ];
    }
}