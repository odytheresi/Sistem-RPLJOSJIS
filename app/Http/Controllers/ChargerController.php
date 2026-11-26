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

    /** Memastikan yang login adalah operator. */
    private function currentOperator(): Operator
    {
        $operator = Operator::where('id_user', auth()->user()->id_user)->first();
        abort_if(!$operator, 403, 'Akun ini bukan operator.');

        return $operator;
    }

    /** Semua stasiun (semua operator berbagi data). */
    private function allStationIds(): array
    {
        return ChargingStation::pluck('id_station')->all();
    }

    /** Semua stasiun aktif untuk dropdown (tidak peka huruf besar/kecil). */
    private function activeStations()
    {
        return ChargingStation::whereRaw('LOWER(status) = ?', ['aktif'])
            ->orderBy('nama_st')
            ->get();
    }

    /** Ambil charger, 404 kalau tidak ada. */
    private function findCharger($id): Charger
    {
        return Charger::with(['station', 'konektor', 'tarifs'])->findOrFail($id);
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
            'id_station.in'        => 'Stasiun tidak valid atau tidak aktif.',
            'id_station.required'  => 'Stasiun wajib dipilih.',
            'id_konektor.required' => 'Tipe konektor wajib dipilih.',
            'id_konektor.exists'   => 'Tipe konektor tidak ditemukan.',
            'kd_charger.required'  => 'Kode charger wajib diisi.',
            'kd_charger.unique'    => 'Kode charger sudah dipakai.',
            'daya_maks.required'   => 'Daya maksimum wajib diisi.',
            'daya_maks.numeric'    => 'Daya maksimum harus berupa angka.',
            'daya_maks.min'        => 'Daya maksimum minimal 0,1 kW.',
            'status.in'            => 'Status tidak valid.',
        ];
    }

    public function index(Request $request)
    {
        $this->currentOperator();
        $stationIds = $this->allStationIds();

        $base = Charger::whereIn('id_station', $stationIds);

        $counts = [
            'semua'     => (clone $base)->count(),
            'tersedia'  => (clone $base)->where('status', 'tersedia')->count(),
            'digunakan' => (clone $base)->where('status', 'digunakan')->count(),
            'perbaikan' => (clone $base)->where('status', 'perbaikan')->count(),
            'error'     => (clone $base)->where('status', 'error')->count(),
        ];

        $filter = $request->query('status');
        $q = trim((string) $request->query('q', ''));

        $chargers = Charger::with(['station', 'konektor', 'tarifs'])
            ->whereIn('id_station', $stationIds)
            ->when(
                in_array($filter, ['tersedia', 'digunakan', 'perbaikan', 'error'], true),
                fn ($query) => $query->where('status', $filter)
            )
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('kd_charger', 'like', "%{$q}%")
                      ->orWhere('status', 'like', "%{$q}%")
                      ->orWhereHas('station', fn ($s) => $s->where('nama_st', 'like', "%{$q}%"))
                      ->orWhereHas('konektor', fn ($k) => $k
                          ->where('nama_konektor', 'like', "%{$q}%")
                          ->orWhere('jenis_charging', 'like', "%{$q}%"));
                });
            })
            ->orderBy('id_station')
            ->orderBy('kd_charger')
            ->paginate(10)
            ->withQueryString();

        return view('operator.charger.index', compact('chargers', 'counts', 'filter', 'q'));
    }

    public function create()
    {
        $this->currentOperator();

        return view('operator.charger.create', [
            'stations'  => $this->activeStations(),
            'konektors' => TipeKonektor::orderBy('nama_konektor')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->currentOperator();
        $activeIds = $this->activeStations()->pluck('id_station')->all();

        $data = $request->validate($this->rules($activeIds), $this->messages());

        (new Charger())->forceFill($data)->save();

        return redirect()->route('operator.charger.index')
            ->with('success', 'Charger berhasil ditambahkan.');
    }

    public function show($id)
    {
        $this->currentOperator();
        $charger = $this->findCharger($id);

        return view('operator.charger.show', compact('charger'));
    }

    public function edit($id)
    {
        $this->currentOperator();
        $charger = $this->findCharger($id);

        // Stasiun aktif + stasiun charger saat ini (agar tetap tampil walau sudah non-aktif)
        $stations = $this->activeStations();
        if (!$stations->contains('id_station', $charger->id_station) && $charger->station) {
            $stations->push($charger->station);
        }

        return view('operator.charger.edit', [
            'charger'   => $charger,
            'stations'  => $stations,
            'konektors' => TipeKonektor::orderBy('nama_konektor')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->currentOperator();
        $charger = $this->findCharger($id);

        $allowedIds = $this->activeStations()->pluck('id_station')->all();
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
        $this->currentOperator();
        $charger = $this->findCharger($id);

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