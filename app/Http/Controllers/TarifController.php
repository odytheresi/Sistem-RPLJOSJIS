<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use App\Models\ChargingStation;
use Illuminate\Http\Request;

class TarifController extends Controller
{
   
    public function index()
    {
        $tarifs = Tarif::all();

        return view(
            'operator.tarif.index',
            compact('tarifs')
        );
    }

    
    public function create()
    {
        $stations = ChargingStation::all();

        return view(
            'operator.tarif.create',
            compact('stations')
        );
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'id_station' => 'required|integer',
            'harga_per_kwh' => 'required|numeric',
            'berlaku_mulai' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Tarif::create([
            'id_station' => $request->id_station,
            'harga_per_kwh' => $request->harga_per_kwh,
            'berlaku_mulai' => $request->berlaku_mulai,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil ditambahkan.'
            );
    }

   
    public function show($id)
    {
        $tarif = Tarif::findOrFail($id);

        return view(
            'operator.tarif.show',
            compact('tarif')
        );
    }

   
    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);

        $stations = ChargingStation::all();

        return view(
            'operator.tarif.edit',
            compact('tarif', 'stations')
        );
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_station' => 'required|integer',
            'harga_per_kwh' => 'required|numeric',
            'berlaku_mulai' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $tarif = Tarif::findOrFail($id);

        $tarif->update([
            'id_station' => $request->id_station,
            'harga_per_kwh' => $request->harga_per_kwh,
            'berlaku_mulai' => $request->berlaku_mulai,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil diperbarui.'
            );
    }

    
    public function destroy($id)
    {
        $tarif = Tarif::findOrFail($id);

        $tarif->delete();

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil dihapus.'
            );
    }
}