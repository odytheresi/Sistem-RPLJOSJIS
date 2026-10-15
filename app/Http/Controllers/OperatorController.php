<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ChargingStation;
use App\Models\Charger;
use App\Models\Tarif;
use App\Models\Perbaikan;
use App\Models\Keluhan;

class OperatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $operator = $user->operator;

        // Ambil data untuk tabel dashboard
        $chargingStations = ChargingStation::all();
        $chargers = Charger::all();
        $tarifs = Tarif::all();
        $perbaikan = Perbaikan::all();
        $keluhan = Keluhan::all();

        // Hitung jumlah data
        $totalStation = $chargingStations->count();
        $totalCharger = $chargers->count();
        $totalTarif = $tarifs->count();
        $totalPerbaikan = $perbaikan->count();
        $totalKeluhan = $keluhan->count();

        return view('operator.dashboard', [
            'operator' => $operator,
            'chargingStations' => $chargingStations,
            'chargers' => $chargers,
            'tarifs' => $tarifs,
            'perbaikan' => $perbaikan,
            'keluhan' => $keluhan,
            'totalStation' => $totalStation,
            'totalCharger' => $totalCharger,
            'totalTarif' => $totalTarif,
            'totalPerbaikan' => $totalPerbaikan,
            'totalKeluhan' => $totalKeluhan,
        ]);
    }
}
