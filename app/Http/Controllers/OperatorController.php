<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChargingStation;
use App\Models\Charger;
use App\Models\Tarif; // (Opsional) Uncomment jika tabel tarifs sudah dibuat

class OperatorController extends Controller 
{
    public function index() 
    {
        // Opsional: Validasi session login manual if
        if (!session()->has('user_id')) {
            return redirect('/login');
        }

        // Data identitas operator yang sedang login
        $operator = [
            'id_operator' => session('user_id', 1),
            'nama'        => session('nama', 'Budi Santoso'),
            'user_id'     => session('user_id', 1)
        ];

        // 1. Logika Hitung Data
        $totalStation        = ChargingStation::count();
        $totalCharger        = Charger::count();
        $chargerAktif        = Charger::where('status', 'aktif')->count();
        $chargerNonaktif     = Charger::where('status', 'nonaktif')->count();
        $chargerMaintenance  = Charger::where('status', 'maintenance')->count();
        // $totalTarif       = Tarif::count(); // Dinonaktifkan sementara

        // 2. Data Tambahan untuk Mengisi Tabel di View Anda
        $chargingStations = ChargingStation::all();
        $chargers         = Charger::with(['chargingStation', 'tipeKonektor'])->get();
        $tarifs        = Tarif::with('charger')->get(); // Dinonaktifkan sementara
        $keluhan          = []; 

        // Kirim semua variabel ke view operator.dashboard
        return view('operator.dashboard', compact(
            'operator',
            'totalStation',
            'totalCharger',
            'chargerAktif',
            'chargerNonaktif',
            'chargerMaintenance',
            //'totalTarif',
            'chargingStations',
            'chargers',
            'tarifs',
            'keluhan'
        ));
    }

    public function lokasiStasiun()
    {
        // Mengambil semua data stasiun beserta relasi chargers dan tipe konektornya
        $chargingStations = ChargingStation::with(['chargers.tipeKonektor', 'chargers.tarifs'])->get();

        return view('operator.lokasi_stasiun', compact('chargingStations'));
    }
}