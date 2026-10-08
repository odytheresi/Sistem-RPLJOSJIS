<?php

namespace App\Http\Controllers;

use App\Models\ChargingStation;
use App\Models\Operator;
use Illuminate\Http\Request;

class ChargingStationController extends Controller
{
    /**
     * Menampilkan seluruh charging station.
     */
    public function index()
    {
        $stations = ChargingStation::all();

        return view(
            'operator.station.index',
            compact('stations')
        );
    }

    /**
     * Menampilkan form tambah charging station.
     */
    public function create()
    {
        $operators = Operator::all();

        return view(
            'operator.station.create',
            compact('operators')
        );
    }

    /**
     * Menyimpan charging station baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_operator' => 'required|integer',
            'nama_st' => 'required|string|max:100',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:aktif,nonaktif,maintenance',
        ]);

        ChargingStation::create([
            'id_operator' => $request->id_operator,
            'nama_st' => $request->nama_st,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil ditambahkan.'
            );
    }

    
    public function show($id)
    {
        $station = ChargingStation::findOrFail($id);

        return view(
            'operator.station.show',
            compact('station')
        );
    }

    
    public function edit($id)
    {
        $station = ChargingStation::findOrFail($id);

        $operators = Operator::all();

        return view(
            'operator.station.edit',
            compact('station', 'operators')
        );
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_operator' => 'required|integer',
            'nama_st' => 'required|string|max:100',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:aktif,nonaktif,maintenance',
        ]);

        $station = ChargingStation::findOrFail($id);

        $station->update([
            'id_operator' => $request->id_operator,
            'nama_st' => $request->nama_st,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil diperbarui.'
            );
    }

    
    public function destroy($id)
    {
        $station = ChargingStation::findOrFail($id);

        $station->delete();

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil dihapus.'
            );
    }
}