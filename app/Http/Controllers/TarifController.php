<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\Tarif;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TarifController extends Controller
{
    public function index(): View
    {
        $operator = auth()->user()->operator;

        $tarifs = Tarif::with([
            'station',
            'charger'
        ])
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->latest('berlaku_mulai')
        ->get();

        return view(
            'operator.tarif.index',
            compact('tarifs')
        );
    }

    public function create(): View
    {
        $operator = auth()->user()->operator;

        $chargers = Charger::with('station')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->get();

        return view(
            'operator.tarif.create',
            compact('chargers')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_charger' => [
                'required',
                'integer'
            ],
            'harga_per_kwh' => [
                'required',
                'numeric',
                'min:0'
            ],
            'berlaku_mulai' => [
                'required',
                'date'
            ],
            'berlaku_selesai' => [
                'nullable',
                'date',
                'after:berlaku_mulai'
            ],
        ]);

        $charger = $this->getOwnedCharger(
            $validated['id_charger']
        );

        Tarif::create([
            'id_station' => $charger->id_station,
            'id_charger' => $charger->id_charger,
            'harga_per_kwh' => $validated['harga_per_kwh'],
            'berlaku_mulai' => $validated['berlaku_mulai'],
            'berlaku_selesai' =>
                $validated['berlaku_selesai'] ?? null,
        ]);

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil ditambahkan.'
            );
    }

    public function edit(Tarif $tarif): View
    {
        $this->checkOwner($tarif);

        $operator = auth()->user()->operator;

        $chargers = Charger::with('station')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->get();

        return view(
            'operator.tarif.edit',
            compact(
                'tarif',
                'chargers'
            )
        );
    }

    public function update(
        Request $request,
        Tarif $tarif
    ): RedirectResponse {

        $this->checkOwner($tarif);

        $validated = $request->validate([
            'id_charger' => [
                'required',
                'integer'
            ],
            'harga_per_kwh' => [
                'required',
                'numeric',
                'min:0'
            ],
            'berlaku_mulai' => [
                'required',
                'date'
            ],
            'berlaku_selesai' => [
                'nullable',
                'date',
                'after:berlaku_mulai'
            ],
        ]);

        $charger = $this->getOwnedCharger(
            $validated['id_charger']
        );

        $tarif->update([
            'id_station' => $charger->id_station,
            'id_charger' => $charger->id_charger,
            'harga_per_kwh' => $validated['harga_per_kwh'],
            'berlaku_mulai' => $validated['berlaku_mulai'],
            'berlaku_selesai' =>
                $validated['berlaku_selesai'] ?? null,
        ]);

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil diperbarui.'
            );
    }

    public function destroy(
        Tarif $tarif
    ): RedirectResponse {

        $this->checkOwner($tarif);

        $tarif->delete();

        return redirect()
            ->route('operator.tarif.index')
            ->with(
                'success',
                'Tarif berhasil dihapus.'
            );
    }

    private function getOwnedCharger(
        int $chargerId
    ): Charger {

        return Charger::where(
            'id_charger',
            $chargerId
        )
        ->whereHas('station', function ($query) {
            $query->where(
                'id_operator',
                auth()->user()->operator->id_operator
            );
        })
        ->firstOrFail();
    }

    private function checkOwner(Tarif $tarif): void
    {
        abort_unless(
            $tarif->station->id_operator ===
            auth()->user()->operator->id_operator,
            403
        );
    }
}