<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\Operator;
use App\Models\Tarif;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TarifController extends Controller
{
    private function currentOperator(): Operator
    {
        $op = session('user_id')
            ? Operator::where('id_user', session('user_id'))->first()
            : null;

        if (!$op) {
            throw new HttpResponseException(redirect('/login'));
        }

        return $op;
    }

    private function ownedChargers(Operator $op)
    {
        return Charger::with('station')
            ->whereHas('station', fn ($q) => $q->where('id_operator', $op->id_operator));
    }

    private function rules(): array
    {
        return [
            'id_charger'    => ['required', 'integer'],
            'harga_per_kWh' => ['required', 'numeric', 'min:0'],
            'berlaku_mulai' => ['required', 'date'],
        ];
    }

    public function index(): View
    {
        $op = $this->currentOperator();

        $tarifs = Tarif::with('charger.station')
            ->whereHas('charger.station', fn ($q) => $q->where('id_operator', $op->id_operator))
            ->orderByDesc('berlaku_mulai')
            ->get();

        return view('operator.tarif.index', compact('tarifs'));
    }

    public function create(): View
    {
        $chargers = $this->ownedChargers($this->currentOperator())->get();

        return view('operator.tarif.create', compact('chargers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $op = $this->currentOperator();
        $data = $request->validate($this->rules());

        $charger = $this->ownedChargers($op)->where('id_charger', $data['id_charger'])->firstOrFail();

        Tarif::create([
            'id_charger'    => $charger->id_charger,
            'harga_per_kWh' => $data['harga_per_kWh'],
            'berlaku_mulai' => $data['berlaku_mulai'],
        ]);

        return redirect()->route('operator.tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit(Tarif $tarif): View
    {
        $op = $this->currentOperator();
        $this->checkOwner($tarif, $op);

        $chargers = $this->ownedChargers($op)->get();

        return view('operator.tarif.edit', compact('tarif', 'chargers'));
    }

    public function update(Request $request, Tarif $tarif): RedirectResponse
    {
        $op = $this->currentOperator();
        $this->checkOwner($tarif, $op);

        $data = $request->validate($this->rules());

        $charger = $this->ownedChargers($op)->where('id_charger', $data['id_charger'])->firstOrFail();

        $tarif->update([
            'id_charger'    => $charger->id_charger,
            'harga_per_kWh' => $data['harga_per_kWh'],
            'berlaku_mulai' => $data['berlaku_mulai'],
        ]);

        return redirect()->route('operator.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Tarif $tarif): RedirectResponse
    {
        $this->checkOwner($tarif, $this->currentOperator());

        $tarif->delete();

        return redirect()->route('operator.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }

    private function checkOwner(Tarif $tarif, Operator $op): void
    {
        $owner = optional(optional($tarif->charger)->station)->id_operator;

        abort_unless($owner === $op->id_operator, 403);
    }
}