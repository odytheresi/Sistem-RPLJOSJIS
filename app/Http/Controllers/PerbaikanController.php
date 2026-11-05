<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use App\Models\Keluhan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PerbaikanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - Daftar Maintenance
    |--------------------------------------------------------------------------
    */

  public function index(): View
{
    $operator = auth()->user()->operator;

    abort_unless($operator, 403);

    // Mengambil data maintenance milik operator login.
    $perbaikans = Perbaikan::with([
        'charger.station',
        'charger.konektor',
        'keluhan'
    ])
    ->whereHas('charger.station', function ($query) use ($operator) {
        $query->where(
            'id_operator',
            $operator->id_operator
        );
    })
    ->latest('tgl_jadwal')
    ->get();

    return view(
        'operator.perbaikan.index',
        compact('perbaikans')
    );
}


    /*
    |--------------------------------------------------------------------------
    | CREATE - Form Tambah Maintenance
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $operator = auth()->user()->operator;

        // Hanya mengambil charger yang berstatus error.
        $chargers = Charger::with('station')
            ->where('status', 'error')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->get();

        // Mengambil keluhan yang belum selesai atau ditolak.
        $keluhan = Keluhan::with('station')
            ->whereIn('status', [
                'menunggu',
                'diproses'
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
            'operator.perbaikan.create',
            compact(
                'chargers',
                'keluhan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE - Simpan Jadwal Maintenance
    |--------------------------------------------------------------------------
    */
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
        ]);

        $charger = $this->getOwnedCharger(
            (int) $validated['id_charger']
        );

        // Charger wajib berstatus error.
        if ($charger->status !== 'error') {
            throw ValidationException::withMessages([
                'id_charger' =>
                    'Charger harus berstatus error untuk dijadwalkan maintenance.'
            ]);
        }

        // Pastikan keluhan berasal dari stasiun yang sama.
        if (!empty($validated['id_keluhan'])) {
            $this->getOwnedKeluhan(
                (int) $validated['id_keluhan'],
                $charger->id_station
            );
        }

        DB::transaction(function () use (
            $validated,
            $charger
        ) {
            $perbaikan = Perbaikan::create([
                'id_charger' => $charger->id_charger,

                'id_keluhan' =>
                    $validated['id_keluhan'] ?? null,

                'tgl_jadwal' => $validated['tgl_jadwal'],

                'jenis_maintenance' =>
                    $validated['jenis_maintenance'],

                'keterangan' =>
                    $validated['keterangan'] ?? null,

                'status' => 'dijadwalkan',

                'tgl_selesai' => null,
            ]);

            // Sinkronisasi status charger.
            $this->syncChargerStatus($charger);
        });

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Jadwal maintenance berhasil dibuat.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW - Detail Maintenance
    |--------------------------------------------------------------------------
    */

    public function show(Perbaikan $perbaikan): View
    {
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


    /*
    |--------------------------------------------------------------------------
    | EDIT - Form Edit Maintenance
    |--------------------------------------------------------------------------
    */

    public function edit(Perbaikan $perbaikan): View
    {
        {
    // Pastikan maintenance milik operator login.
    $this->checkOwner($perbaikan);

    $operator = auth()->user()->operator;

    abort_unless($operator, 403);

    // Charger error dan charger yang sedang digunakan
    // oleh jadwal maintenance ini.
    $chargers = Charger::with('station')
        ->where(function ($query) use ($perbaikan) {
            $query->where('status', 'error')
                ->orWhere(
                    'id_charger',
                    $perbaikan->id_charger
                );
        })
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->get();

    // Keluhan aktif dan keluhan yang sudah terhubung
    // dengan maintenance ini.
    $keluhan = Keluhan::with('station')
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->where(function ($query) use ($perbaikan) {
            $query->whereIn('status', [
                'menunggu',
                'diproses'
            ]);

            if ($perbaikan->id_keluhan) {
                $query->orWhere(
                    'id_keluhan',
                    $perbaikan->id_keluhan
                );
            }
        })
        ->get();

    return view(
        'operator.perbaikan.edit',
        compact(
            'perbaikan',
            'chargers',
            'keluhan'
        )
    );
}
    

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE - Perbarui Jadwal dan Status Maintenance
    |--------------------------------------------------------------------------
    */

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
        ]);

        $chargerBaru = $this->getOwnedCharger(
            (int) $validated['id_charger']
        );

        $chargerLama = $perbaikan->charger;

        // Jika mengganti charger, charger baru wajib error.
        if (
            $chargerBaru->id_charger !== $chargerLama->id_charger
            && $chargerBaru->status !== 'error'
        ) {
            throw ValidationException::withMessages([
                'id_charger' =>
                    'Charger pengganti harus berstatus error.'
            ]);
        }

        // Validasi keluhan harus berasal dari stasiun charger baru.
        if (!empty($validated['id_keluhan'])) {
            $this->getOwnedKeluhan(
                (int) $validated['id_keluhan'],
                $chargerBaru->id_station
            );
        }

        DB::transaction(function () use (
            $validated,
            $perbaikan,
            $chargerLama,
            $chargerBaru
        ) {
            $perbaikan->update([
                'id_charger' => $chargerBaru->id_charger,

                'id_keluhan' =>
                    $validated['id_keluhan'] ?? null,

                'tgl_jadwal' => $validated['tgl_jadwal'],

                'jenis_maintenance' =>
                    $validated['jenis_maintenance'],

                'keterangan' =>
                    $validated['keterangan'] ?? null,

                'status' => $validated['status'],

                // Tanggal selesai otomatis terisi.
                'tgl_selesai' =>
                    $validated['status'] === 'selesai'
                        ? ($perbaikan->tgl_selesai ?? now())
                        : null,
            ]);

            // Jika charger berubah, sinkronkan keduanya.
            $this->syncChargerStatus($chargerLama);

            if (
                $chargerLama->id_charger !== $chargerBaru->id_charger
            ) {
                $this->syncChargerStatus($chargerBaru);
            }
        });

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Data maintenance berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY - Hapus Jadwal Maintenance
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Perbaikan $perbaikan
    ): RedirectResponse {

        $this->checkOwner($perbaikan);

        $charger = $perbaikan->charger;

        DB::transaction(function () use (
            $perbaikan,
            $charger
        ) {
            $perbaikan->delete();

            // Perbarui status charger setelah jadwal dihapus.
            $this->syncChargerStatus($charger);
        });

        return redirect()
            ->route('operator.perbaikan.index')
            ->with(
                'success',
                'Jadwal maintenance berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GET OWNED CHARGER
    |--------------------------------------------------------------------------
    | Memastikan charger merupakan milik operator login.
    */

    private function getOwnedCharger(
        int $chargerId
    ): Charger {

        $operator = auth()->user()->operator;

        return Charger::where(
            'id_charger',
            $chargerId
        )
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | GET OWNED KELUHAN
    |--------------------------------------------------------------------------
    | Memastikan keluhan berasal dari stasiun yang benar
    | dan masih dimiliki operator yang login.
    */

    private function getOwnedKeluhan(
        int $keluhanId,
        int $stationId
    ): Keluhan {

        $operator = auth()->user()->operator;

        return Keluhan::where(
            'id_keluhan',
            $keluhanId
        )
        ->where(
            'id_station',
            $stationId
        )
        ->whereHas('station', function ($query) use ($operator) {
            $query->where(
                'id_operator',
                $operator->id_operator
            );
        })
        ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK OWNER
    |--------------------------------------------------------------------------
    | Memeriksa kepemilikan jadwal maintenance.
    */

    private function checkOwner(
        Perbaikan $perbaikan
    ): void {

        abort_unless(
            $perbaikan->charger
                && $perbaikan->charger->station
                && $perbaikan->charger->station->id_operator
                    === auth()->user()->operator->id_operator,
            403
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SYNCHRONIZE CHARGER STATUS
    |--------------------------------------------------------------------------
    | Menyesuaikan status charger berdasarkan riwayat maintenance.
    */

    private function syncChargerStatus(
        Charger $charger
    ): void {

        // Jika masih ada maintenance aktif,
        // charger tetap dalam status maintenance.
        $hasActiveMaintenance = Perbaikan::where(
            'id_charger',
            $charger->id_charger
        )
        ->whereIn('status', [
            'dijadwalkan',
            'proses'
        ])
        ->exists();

        if ($hasActiveMaintenance) {
            $charger->update([
                'status' => 'maintenance'
            ]);

            return;
        }

        // Ambil riwayat maintenance terbaru.
        $latest = Perbaikan::where(
            'id_charger',
            $charger->id_charger
        )
        ->latest('tgl_jadwal')
        ->latest('id_perbaikan')
        ->first();

        if ($latest && $latest->status === 'selesai') {

            // Charger kembali tersedia setelah perbaikan selesai.
            $charger->update([
                'status' => 'tersedia'
            ]);

        } else {

            // Jika dibatalkan atau tidak memiliki jadwal aktif,
            // charger tetap dianggap bermasalah.
            $charger->update([
                'status' => 'error'
            ]);
        }
    }
}
