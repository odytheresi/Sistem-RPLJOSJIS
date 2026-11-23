<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StationApiController extends Controller
{
    public function show($id)
    {
        // Mengambil data stasiun beserta relasi charger, tipe konektor, dan tarif dari database
        $station = ChargingStation::with(['chargers.tipeKonektor', 'chargers.tarifs'])->find($id);

        if (!$station) {
            return response()->json([
                'success' => false,
                'message' => 'Stasiun tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $station
        ]);
    }
}
