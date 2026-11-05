<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\View\View;

class KeluhanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX - Daftar Keluhan Pengemudi
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $operator = auth()->user()->operator;

        abort_unless($operator, 403);

        // Mengambil keluhan hanya dari stasiun milik operator login.
        $keluhan = Keluhan::with('station')
            ->whereNotNull('id_pengemudi')
            ->whereHas('station', function ($query) use ($operator) {
                $query->where(
                    'id_operator',
                    $operator->id_operator
                );
            })
            ->latest()
            ->get();

        return view(
            'operator.keluhan.index',
            compact('keluhan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW - Detail Keluhan
    |--------------------------------------------------------------------------
    */

    public function show(Keluhan $keluhan): View
    {
        $this->checkOwner($keluhan);

        $keluhan->load([
            'station'
        ]);

        return view(
            'operator.keluhan.show',
            compact('keluhan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK OWNER - Pemeriksaan Kepemilikan Keluhan
    |--------------------------------------------------------------------------
    */

    private function checkOwner(Keluhan $keluhan): void
    {
        $operator = auth()->user()->operator;

        abort_unless(
            $operator &&
            $keluhan->station()
                ->where(
                    'id_operator',
                    $operator->id_operator
                )
                ->exists(),
            403
        );
    }
}
