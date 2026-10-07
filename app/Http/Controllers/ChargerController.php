<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\ChargingStation;
use App\Models\TipeKonektor;
use Illuminate\Http\Request;

class ChargerController extends Controller
{
    
    public function index()
    {
        $chargers = Charger::all();

        return view(
            'operator.charger.index',
            compact('chargers')
        );
    }

    
    public function create()
    {
        $stations = ChargingStation::all();

        $konektors = TipeKonektor::all();

        return view(
            'operator.charger.create',
            compact('stations', 'konektors')
        );
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'id_station' => 'required|integer',
            'id_konektor' => 'required|integer',
            'kd_charger' => 'required|string|max:100',
            'daya_maks' => 'required|numeric',
            'status' => 'required|in:aktif,nonaktif,maintenance',
        ]);

        Charger::create([
            'id_station' => $request->id_station,
            'id_konektor' => $request->id_konektor,
            'kd_charger' => $request->kd_charger,
            'daya_maks' => $request->daya_maks,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Charger berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail charger.
     */
    public function show($id)
    {
        $charger = Charger::findOrFail($id);

        return view(
            'operator.charger.show',
            compact('charger')
        );
    }

    /**
     * Menampilkan form edit charger.
     */
    public function edit($id)
    {
        $charger = Charger::findOrFail($id);

        $stations = ChargingStation::all();

        $konektors = TipeKonektor::all();

        return view(
            'operator.charger.edit',
            compact(
                'charger',
                'stations',
                'konektors'
            )
        );
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_station' => 'required|integer',
            'id_konektor' => 'required|integer',
            'kd_charger' => 'required|string|max:100',
            'daya_maks' => 'required|numeric',
            'status' => 'required|in:aktif,nonaktif,maintenance',
        ]);

        $charger = Charger::findOrFail($id);

        $charger->update([
            'id_station' => $request->id_station,
            'id_konektor' => $request->id_konektor,
            'kd_charger' => $request->kd_charger,
            'daya_maks' => $request->daya_maks,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Charger berhasil diperbarui.'
            );
    }

    
    public function destroy($id)
    {
        $charger = Charger::findOrFail($id);

        $charger->delete();

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Charger berhasil dihapus.'
            );
    }
}