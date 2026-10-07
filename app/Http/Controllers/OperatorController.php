<?php

namespace App\Http\Controllers;

use App\Models\ChargingStation;
use App\Models\Charger;
use App\Models\Tarif;

class OperatorController extends Controller
{
    
    public function index()
    {
        
        $totalStation = ChargingStation::count();

        
        $totalCharger = Charger::count();

        
        $chargerAktif = Charger::where('status', 'aktif')->count();

        $chargerNonaktif = Charger::where(
            'status',
            'nonaktif'
        )->count();

        $chargerMaintenance = Charger::where(
            'status',
            'maintenance'
        )->count();

        
        $totalTarif = Tarif::count();

        return view('operator.dashboard', compact(
            'totalStation',
            'totalCharger',
            'chargerAktif',
            'chargerNonaktif',
            'chargerMaintenance',
            'totalTarif'
        ));
    }
}