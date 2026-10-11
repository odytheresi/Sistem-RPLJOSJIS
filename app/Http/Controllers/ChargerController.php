<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\ChargingStation;
use App\Models\TipeKonektor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChargerController extends Controller
{
    public function index(): View
    {
        $operator = auth()->user()->operator;

        $chargers = Charger::with([
            'station',
            'konektor'
        ])
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->latest()
        ->get();

        return view(
            'operator.charger.index',
            compact('chargers')
        );
    }

    public function create(): View
    {
        $operator = auth()->user()->operator;

        $stations = $operator->stations()
            ->where('status', 'aktif')
            ->get();

        $konektors = TipeKonektor::orderBy(
            'nama_konektor'
        )->get();

        return view(
            'operator.charger.create',
            compact(
                'stations',
                'konektors'
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_station' => [
                'required',
                'integer'
            ],
            'id_konektor' => [
                'required',
                'integer'
            ],
            'kode_charger' => [
                'required',
                'string',
                'max:50',
                'unique:charger,kode_charger'
            ],
            'daya_maks' => [
                'required',
                'numeric',
                'min:0'
            ],
            'status' => [
                'required',
                'in:tersedia,digunakan,maintenance,error'
            ],
        ]);

        $this->checkStationOwner(
            $validated['id_station']
        );

        Charger::create($validated);

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Charger berhasil ditambahkan.'
            );
    }

    public function show(Charger $charger): View
    {
        $this->checkOwner($charger);

        $charger->load([
            'station',
            'konektor',
            'tarifs',
            'perbaikan'
        ]);

        return view(
            'operator.charger.show',
            compact('charger')
        );
    }

    public function edit(Charger $charger): View
    {
        $this->checkOwner($charger);

        $operator = auth()->user()->operator;

        $stations = $operator->stations()
            ->where('status', 'aktif')
            ->get();

        $konektors = TipeKonektor::orderBy(
            'nama_konektor'
        )->get();

        return view(
            'operator.charger.edit',
            compact(
                'charger',
                'stations',
                'konektors'
            )
        );
    }

    public function update(
        Request $request,
        Charger $charger
    ): RedirectResponse {

        $this->checkOwner($charger);

        $validated = $request->validate([
            'id_station' => [
                'required',
                'integer'
            ],
            'id_konektor' => [
                'required',
                'integer'
            ],
            'kode_charger' => [
                'required',
                'string',
                'max:50',
                'unique:charger,kode_charger,' .
                $charger->id_charger .
                ',id_charger'
            ],
            'daya_maks' => [
                'required',
                'numeric',
                'min:0'
            ],
            'status' => [
                'required',
                'in:tersedia,digunakan,maintenance,error'
            ],
        ]);

        $this->checkStationOwner(
            $validated['id_station']
        );

        $charger->update($validated);

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Data charger berhasil diperbarui.'
            );
    }

    public function destroy(
        Charger $charger
    ): RedirectResponse {

        $this->checkOwner($charger);

        $charger->delete();

        return redirect()
            ->route('operator.charger.index')
            ->with(
                'success',
                'Charger berhasil dihapus.'
            );
    }

    public function updateStatus(
        Request $request,
        Charger $charger
    ): RedirectResponse {

        $this->checkOwner($charger);

        $validated = $request->validate([
            'status' => [
                'required',
                'in:tersedia,digunakan,maintenance,error'
            ],
        ]);

        $charger->update($validated);

        return back()->with(
            'success',
            'Status charger berhasil diperbarui.'
        );
    }

    private function checkOwner(Charger $charger): void
    {
        abort_unless(
            $charger->station->id_operator ===
            auth()->user()->operator->id_operator,
            403
        );
    }

    private function checkStationOwner(
        int $stationId
    ): void {

        ChargingStation::where(
            'id_station',
            $stationId
        )
        ->where(
            'id_operator',
            auth()->user()->operator->id_operator
        )
        ->firstOrFail();
    }
}