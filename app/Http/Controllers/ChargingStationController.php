<?php

namespace App\Http\Controllers;

use App\Models\ChargingStation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChargingStationController extends Controller
{
    public function index(): View
    {
        $stations = ChargingStation::withCount('chargers')
            ->latest()
            ->get();

        return view(
            'operator.station.index',
            compact('stations')
        );
    }

    public function create(): View
    {
        return view('operator.station.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_st' => [
                'required',
                'string',
                'max:100'
            ],
            'alamat' => [
                'required',
                'string'
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],
            'status' => [
                'required',
                'in:aktif,nonaktif,maintenance'
            ],
        ]);

        // id_operator tetap dicatat sebagai pembuat stasiun
        $operator = auth()->user()->operator;

        $operator->stations()->create($validated);

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil ditambahkan.'
            );
    }

    public function show(ChargingStation $station): View
    {
        $station->load([
            'chargers.konektor',
            'tarifs',
            'keluhan',
        ]);

        return view(
            'operator.station.show',
            compact('station')
        );
    }

    public function edit(ChargingStation $station): View
    {
        return view(
            'operator.station.edit',
            compact('station')
        );
    }

    public function update(
        Request $request,
        ChargingStation $station
    ): RedirectResponse {

        $validated = $request->validate([
            'nama_st' => [
                'required',
                'string',
                'max:100'
            ],
            'alamat' => [
                'required',
                'string'
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],
            'status' => [
                'required',
                'in:aktif,nonaktif,maintenance'
            ],
        ]);

        $station->update($validated);

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil diperbarui.'
            );
    }

    public function destroy(
        ChargingStation $station
    ): RedirectResponse {

        $station->delete();

        return redirect()
            ->route('operator.station.index')
            ->with(
                'success',
                'Charging station berhasil dihapus.'
            );
    }
}