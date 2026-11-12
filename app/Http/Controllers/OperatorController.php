<?php

namespace App\Http\Controllers;

use App\Models\ChargingStation;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index(): View|RedirectResponse
    {
        // Login proyek ini memakai sesi manual
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $op = Operator::where('id_user', $userId)->first();

        if (!$op) {
            return redirect('/login')->withErrors([
                'login' => 'Akun ini belum terdaftar sebagai operator.',
            ]);
        }

        $operator = [
            'id_operator' => $op->id_operator,
            'nama'        => $op->nama_operator ?: 'Operator',
            'no_hp'       => $op->no_hp,
        ];

        // ===== Stasiun =====
        $stationRows = DB::table('charging_station')
            ->where('id_operator', $op->id_operator)
            ->orderBy('id_station')
            ->get();

        $stationIds = $stationRows->pluck('id_station');

        $chargingStations = $stationRows->map(fn ($s) => [
            'id'         => $s->id_station,
            'id_station' => $s->id_station,
            'nama_st'    => $s->nama_st,
            'alamat'     => $s->alamat,
            'status'     => $s->status,
        ])->values();

        // ===== Charger =====
        $chargers = DB::table('charger')
            ->join('charging_station', 'charger.id_station', '=', 'charging_station.id_station')
            ->leftJoin('tipe_konektor', 'charger.id_konektor', '=', 'tipe_konektor.id_konektor')
            ->whereIn('charger.id_station', $stationIds)
            ->select(
                'charger.id_charger',
                'charger.kd_charger',
                'charger.daya_maks',
                'charger.status',
                'charging_station.nama_st',
                'tipe_konektor.nm_konektor'
            )
            ->orderBy('charger.id_charger')
            ->get()
            ->map(fn ($c) => [
                'id_charger'       => $c->id_charger,
                'kd_charger'       => $c->kd_charger,
                'daya_maks'        => $c->daya_maks,
                'status'           => $c->status,
                'charging_station' => ['nama_st' => $c->nama_st],
                'tipe_konektor'    => ['nm_konektor' => $c->nm_konektor],
            ])->values();

        // ===== Tarif =====
        $tarifs = DB::table('tarifs')
            ->join('charger', 'tarifs.id_charger', '=', 'charger.id_charger')
            ->join('charging_station', 'charger.id_station', '=', 'charging_station.id_station')
            ->whereIn('charger.id_station', $stationIds)
            ->select(
                'tarifs.id',
                'tarifs.harga_per_kWh',
                'tarifs.berlaku_mulai',
                'charging_station.nama_st'
            )
            ->orderBy('tarifs.id')
            ->get()
            ->map(fn ($t) => [
                'id'            => $t->id,
                'harga_per_kWh' => $t->harga_per_kWh,
                'berlaku_mulai' => $t->berlaku_mulai,
                'charger'       => [
                    'charging_station' => ['nama_st' => $t->nama_st],
                ],
            ])->values();

        // ===== Keluhan =====
        $keluhan = DB::table('keluhan')
            ->leftJoin('charging_station', 'keluhan.id_station', '=', 'charging_station.id_station')
            ->leftJoin('pengemudi', 'keluhan.id_pengemudi', '=', 'pengemudi.id_pengemudi')
            ->leftJoin('login', 'pengemudi.user_id', '=', 'login.user_id')
            ->whereIn('keluhan.id_station', $stationIds)
            ->select(
                'keluhan.created_at',
                'keluhan.isi_keluhan',
                'keluhan.status',
                'charging_station.nama_st',
                'login.nma_user'
            )
            ->orderByDesc('keluhan.created_at')
            ->limit(10)
            ->get()
            ->map(fn ($k) => [
                'tanggal'   => $k->created_at ? Carbon::parse($k->created_at)->format('d/m/Y') : '-',
                'stasiun'   => $k->nama_st ?? '-',
                'pengemudi' => $k->nma_user ?? '-',
                'keluhan'   => $k->isi_keluhan ?? '-',
                'status'    => $k->status,
            ])->values();

        // ===== Angka statistik =====
        $perStatus = DB::table('charger')
            ->whereIn('id_station', $stationIds)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalStation       = $stationIds->count();
        $totalCharger       = (int) $perStatus->sum();
        $chargerAktif       = (int) ($perStatus['tersedia'] ?? 0) + (int) ($perStatus['digunakan'] ?? 0);
        $chargerNonaktif    = (int) ($perStatus['error'] ?? 0);
        $chargerMaintenance = (int) ($perStatus['perbaikan'] ?? 0);

        return view('operator.dashboard', compact(
            'operator',
            'chargingStations',
            'chargers',
            'tarifs',
            'keluhan',
            'totalStation',
            'totalCharger',
            'chargerAktif',
            'chargerNonaktif',
            'chargerMaintenance'
        ));
    }

    public function lokasiStasiun(): View|RedirectResponse
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login');
        }

        $op = Operator::where('id_user', $userId)->first();

        if (!$op) {
            return redirect('/login')->withErrors([
                'login' => 'Akun ini belum terdaftar sebagai operator.',
            ]);
        }

        $chargingStations = ChargingStation::where('id_operator', $op->id_operator)
            ->with(['chargers.konektor', 'chargers.tarifs'])
            ->orderBy('id_station')
            ->get();

        return view('operator.lokasi_stasiun', compact('chargingStations'));
    }
}