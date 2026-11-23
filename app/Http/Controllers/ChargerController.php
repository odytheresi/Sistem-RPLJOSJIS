<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\ChargingStation;
use App\Models\Operator;
use App\Models\TipeKonektor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChargerController extends Controller
{
    /** Status yang boleh diatur manual oleh operator. 'digunakan' diatur sistem. */
    private const STATUS_MANUAL = ['tersedia', 'perbaikan', 'error'];

    private function currentOperator(): Operator
    {
        $operator = Operator::where('id_user', session('user_id'))->first();
        abort_if(!$operator, 403, 'Akun ini bukan operator.');

        return $operator;
    }

    /** Semua stasiun milik operator (untuk filter kepemilikan). */
    private function ownStationIds(Operator $operator): array
    {
        return ChargingStation::where('id_operator', $operator->id_operator)
            ->pluck('id_station')->all();
    }

    /** Stasiun aktif milik operator untuk dropdown (tidak peka huruf besar/kecil). */
    private function activeStations(Operator $operator)
    {
        return ChargingStation::where('id_operator', $operator->id_operator)
            ->whereRaw('LOWER(status) = ?', ['aktif'])
            ->orderBy('nama_st')
            ->get();
    }

    /** Ambil charger + pastikan milik operator, kalau tidak 403. */
    private function ownedCharger($id, Operator $operator): Charger
    {
        $charger = Charger::with(['station', 'konektor', 'tarifs'])->findOrFail($id);

        abort_unless(
            $charger->station && (int) $charger->station->id_operator === (int) $operator->id_operator,
            403,
            'Charger ini bukan milik stasiun Anda.'
        );

        return $charger;
    }

    private function rules(array $stationIds, ?Charger $charger = null): array
    {
        $rules = [
            'id_station'  => ['required', Rule::in($stationIds)],
            'id_konektor' => ['required', 'exists:tipe_konektor,id_konektor'],
            'kd_charger'  => [
                'required', 'string', 'max:50',
                Rule::unique('charger', 'kd_charger')->ignore($charger?->id_charger, 'id_charger'),
            ],
            'daya_maks'   => ['required', 'numeric', 'min:0.1', 'max:9999'],
        ];

        // Charger yang sedang dipakai tidak boleh diubah statusnya manual.
        if (!$charger || $charger->status !== 'digunakan') {
            $rules['status'] = ['required', Rule::in(self::STATUS_MANUAL)];
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'id_station.in'      => 'Stasiun tidak valid atau tidak aktif.',
            'id_station.required'=> 'Stasiun wajib dipilih.',
            'id_konektor.required' => 'Tipe konektor wajib dipilih.',
            'id_konektor.exists' => 'Tipe konektor tidak ditemukan.',
            'kd_charger.required'=> 'Kode charger wajib diisi.',
            'kd_charger.unique'  => 'Kode charger sudah dipakai.',
            'daya_maks.required' => 'Daya maksimum wajib diisi.',
            'daya_maks.numeric'  => 'Daya maksimum harus berupa angka.',
            'daya_maks.min'      => 'Daya maksimum minimal 0,1 kW.',
            'status.in'          => 'Status tidak valid.',
        ];
    }

    public function index(Request $request)
    {
        $operator = $this->currentOperator();
        $stationIds = $this->ownStationIds($operator);

        $base = Charger::whereIn('id_station', $stationIds);

        $counts = [
            'semua'     => (clone $base)->count(),
            'tersedia'  => (clone $base)->where('status', 'tersedia')->count(),
            'digunakan' => (clone $base)->where('status', 'digunakan')->count(),
            'perbaikan' => (clone $base)->where('status', 'perbaikan')->count(),
            'error'     => (clone $base)->where('status', 'error')->count(),
        ];

        $filter = $request->query('status');

        $chargers = Charger::with(['station', 'konektor', 'tarifs'])
            ->whereIn('id_station', $stationIds)
            ->when(
                in_array($filter, ['tersedia', 'digunakan', 'perbaikan', 'error'], true),
                fn ($q) => $q->where('status', $filter)
            )
            ->orderBy('id_station')
            ->orderBy('kd_charger')
            ->get();

        return view('operator.charger.index', compact('chargers', 'counts', 'filter'));
    }

    public function create()
    {
        $operator = $this->currentOperator();

        return view('operator.charger.create', [
            'stations'  => $this->activeStations($operator),
            'konektors' => TipeKonektor::orderBy('nm_konektor')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $operator = $this->currentOperator();
        $activeIds = $this->activeStations($operator)->pluck('id_station')->all();

        $data = $request->validate($this->rules($activeIds), $this->messages());

        (new Charger())->forceFill($data)->save();

        return redirect()->route('operator.charger.index')
            ->with('success', 'Charger berhasil ditambahkan.');
    }

    public function show($id)
    {
        $operator = $this->currentOperator();
        $charger = $this->ownedCharger($id, $operator);

        return view('operator.charger.show', compact('charger'));
    }

    public function edit($id)
    {
        $operator = $this->currentOperator();
        $charger = $this->ownedCharger($id, $operator);

        // Stasiun aktif + stasiun charger saat ini (agar tetap tampil walau sudah non-aktif)
        $stations = $this->activeStations($operator);
        if (!$stations->contains('id_station', $charger->id_station) && $charger->station) {
            $stations->push($charger->station);
        }

        return view('operator.charger.edit', [
            'charger'   => $charger,
            'stations'  => $stations,
            'konektors' => TipeKonektor::orderBy('nm_konektor')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $operator = $this->currentOperator();
        $charger = $this->ownedCharger($id, $operator);

        $allowedIds = $this->activeStations($operator)->pluck('id_station')->all();
        $allowedIds[] = $charger->id_station; // boleh tetap di stasiun lamanya

        $data = $request->validate($this->rules($allowedIds, $charger), $this->messages());

        $charger->forceFill($data)->save();

        return redirect()->route('operator.charger.show', $charger->id_charger)
            ->with('success', 'Charger berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:tersedia,perbaikan,error',
        ]);

        $charger = Charger::findOrFail($id);

        if ($charger->status === 'digunakan') {
            return back()->with('error', 'Charger sedang digunakan, status tidak dapat diubah.');
        }

        $charger->update(['status' => $request->status]);

        return back()->with('success', 'Status charger berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $operator = $this->currentOperator();
        $charger = $this->ownedCharger($id, $operator);

        if ($charger->status === 'digunakan') {
            return back()->with('error', 'Charger sedang digunakan dan tidak dapat dihapus.');
        }

        try {
            $charger->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Charger tidak dapat dihapus karena masih memiliki data terkait (tarif/transaksi/perbaikan).');
        }

        return redirect()->route('operator.charger.index')
            ->with('success', 'Charger berhasil dihapus.');
    }
}