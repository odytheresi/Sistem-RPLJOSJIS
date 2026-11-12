<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\Keluhan;
use App\Models\Operator;
use App\Models\Perbaikan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerbaikanController extends Controller
{
    public function index(): View
    {
        $operator = $this->currentOperator();

        $perbaikan = Perbaikan::with([
            'charger.station',
            'charger.konektor',
            'keluhan'
        ])
        ->whereHas(
            'charger.station',
            function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            }
        )
        ->latest('tgl_jadwal')
        ->get();

        return view(
            'operator.perbaikan.index',
            compact('perbaikan')
        );
    }

    public function create(): View
    {
        $operator = $this->currentOperator();

        $chargers = Charger::with('station')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->get();

        $keluhan = Keluhan::whereHas(
            'station',
            function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            }
        )
        ->whereIn('status', [
            'menunggu',
            'diproses'
        ])
        ->get();

        return view(
            'operator.perbaikan.create',
            compact(
                'chargers',
                'keluhan'
            )
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_charger' => [
                'required',
                'integer'
            ],
            'id_keluhan' => [
                'nullable',
                'integer'
            ],
            'tgl_jadwal' => [
                'required',
                'date'
            ],
            'jenis_maintenance' => [
                'required',
                'string',
                'max:100'
            ],
            'keterangan' => [
                'nullable',
                'string'
            ],
            'status' => [
                'required',
                'in:dijadwalkan,proses,selesai,dibatalkan'
            ],
        ]);

        $charger = $this->getOwnedCharger(
            $validated['id_charger']
        );

        if (!empty($validated['id_keluhan'])) {
            Keluhan::where(
                'id_keluhan',
                $validated['id_keluhan']
            )
            ->where(
                'id_station',
                $charger->id_station
            )
            ->firstOrFail();
        }

        $perbaikan = Perbaikan::create($validated);

        if (in_array($perbaikan->status, [
            'dijadwalkan',
            'proses'
        ])) {
            $charger->update([
                'status' => 'perbaikan'
            ]);
        }

        if ($perbaikan->status === 'selesai') {
            $charger->update([
                'status' => 'tersedia'
            ]);

            $perbaikan->update([
                'tgl_selesai' => now()
            ]);
        }

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Jadwal maintenance berhasil dibuat.'
            );
    }

    public function show(
        Perbaikan $perbaikan
    ): View {

        $this->checkOwner($perbaikan);

        $perbaikan->load([
            'charger.station',
            'charger.konektor',
            'keluhan.station'
        ]);

        return view(
            'operator.perbaikan.show',
            compact('perbaikan')
        );
    }

    public function edit(
        Perbaikan $perbaikan
    ): View {

        $this->checkOwner($perbaikan);

        $operator = $this->currentOperator();

        $chargers = Charger::with('station')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->get();

        $keluhan = Keluhan::whereHas(
            'station',
            function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            }
        )->get();

        return view(
            'operator.perbaikan.edit',
            compact(
                'perbaikan',
                'chargers',
                'keluhan'
            )
        );
    }

    public function update(
        Request $request,
        Perbaikan $perbaikan
    ): RedirectResponse {

        $this->checkOwner($perbaikan);

        $validated = $request->validate([
            'id_charger' => [
                'required',
                'integer'
            ],
            'id_keluhan' => [
                'nullable',
                'integer'
            ],
            'tgl_jadwal' => [
                'required',
                'date'
            ],
            'jenis_maintenance' => [
                'required',
                'string',
                'max:100'
            ],
            'keterangan' => [
                'nullable',
                'string'
            ],
            'status' => [
                'required',
                'in:dijadwalkan,proses,selesai,dibatalkan'
            ],
            'tgl_selesai' => [
                'nullable',
                'date'
            ],
        ]);

        $charger = $this->getOwnedCharger(
            $validated['id_charger']
        );

        $perbaikan->update([
            'id_charger' => $charger->id_charger,
            'id_keluhan' =>
                $validated['id_keluhan'] ?? null,
            'tgl_jadwal' => $validated['tgl_jadwal'],
            'jenis_maintenance' =>
                $validated['jenis_maintenance'],
            'keterangan' =>
                $validated['keterangan'] ?? null,
            'status' => $validated['status'],
            'tgl_selesai' =>
                $validated['tgl_selesai'] ?? null,
        ]);

        if ($validated['status'] === 'selesai') {

            $charger->update([
                'status' => 'tersedia'
            ]);

            if (!$perbaikan->tgl_selesai) {
                $perbaikan->update([
                    'tgl_selesai' => now()
                ]);
            }

        } elseif (
            in_array(
                $validated['status'],
                ['dijadwalkan', 'proses']
            )
        ) {

            $charger->update([
                'status' => 'perbaikan'
            ]);
        }

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Data maintenance berhasil diperbarui.'
            );
    }

    public function destroy(
        Perbaikan $perbaikan
    ): RedirectResponse {

        $this->checkOwner($perbaikan);

        $perbaikan->delete();

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Data maintenance berhasil dihapus.'
            );
    }

    /**
     * Ambil operator dari sesi login manual (session 'user_id' diisi AuthController).
     */
    private function currentOperator(): Operator
    {
        $operator = Operator::where('id_user', session('user_id'))->first();

        if (!$operator) {
            throw new HttpResponseException(
                redirect('/login')->withErrors([
                    'login' => 'Silakan login sebagai operator terlebih dahulu.',
                ])
            );
        }

        return $operator;
    }

    private function getOwnedCharger(
        int $chargerId
    ): Charger {

        $operatorId = $this->currentOperator()->id_operator;

        return Charger::where(
            'id_charger',
            $chargerId
        )
        ->whereHas('station', function ($query) use ($operatorId) {
            $query->where(
                'id_operator',
                $operatorId
            );
        })
        ->firstOrFail();
    }

    private function checkOwner(
        Perbaikan $perbaikan
    ): void {

        abort_unless(
            (int) $perbaikan->charger->station->id_operator ===
            (int) $this->currentOperator()->id_operator,
            403
        );
    }
}