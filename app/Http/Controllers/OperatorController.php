<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\Keluhan;
use App\Models\Perbaikan;
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index(): View
    {
        $operator = auth()->user()->operator;

        $stationIds = $operator->stations()->pluck('id_station');

        // Satu query untuk semua hitungan status charger
        $perStatus = Charger::whereIn('id_station', $stationIds)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalStation       = $stationIds->count();
        $totalCharger       = (int) $perStatus->sum();
        $chargerTersedia    = (int) ($perStatus['tersedia'] ?? 0);
        $chargerDigunakan   = (int) ($perStatus['digunakan'] ?? 0);
        $chargerMaintenance = (int) ($perStatus['maintenance'] ?? 0);
        $chargerError       = (int) ($perStatus['error'] ?? 0);

        $keluhanMenunggu = Keluhan::whereIn('id_station', $stationIds)
            ->where('status', 'menunggu')
            ->count();

        $maintenanceBerjalan = Perbaikan::whereHas('charger', function ($query) use ($stationIds) {
                $query->whereIn('id_station', $stationIds);
            })
            ->whereIn('status', ['dijadwalkan', 'proses'])
            ->count();

        // Data untuk panel di dashboard
        $stations = $operator->stations()
            ->withCount('chargers')
            ->latest()
            ->take(5)
            ->get();

        $chargerBermasalah = Charger::with('station')
            ->whereIn('id_station', $stationIds)
            ->whereIn('status', ['error', 'maintenance'])
            ->latest()
            ->take(5)
            ->get();

        $keluhanTerbaru = Keluhan::with('station')
            ->whereIn('id_station', $stationIds)
            ->latest()
            ->take(5)
            ->get();

        return view('operator.dashboard', compact(
            'totalStation',
            'totalCharger',
            'chargerTersedia',
            'chargerDigunakan',
            'chargerMaintenance',
            'chargerError',
            'keluhanMenunggu',
            'maintenanceBerjalan',
            'stations',
            'chargerBermasalah',
            'keluhanTerbaru'
        ));
    }
}