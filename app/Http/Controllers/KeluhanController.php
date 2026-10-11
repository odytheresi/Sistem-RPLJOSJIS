<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeluhanController extends Controller
{
    public function index(): View
    {
        $operator = auth()->user()->operator;

        $keluhan = Keluhan::with('station')
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

    public function show(Keluhan $keluhan): View
    {
        $this->checkOwner($keluhan);

        $keluhan->load([
            'station',
            'perbaikan.charger'
        ]);

        return view(
            'operator.keluhan.show',
            compact('keluhan')
        );
    }

    public function updateStatus(
        Request $request,
        Keluhan $keluhan
    ): RedirectResponse {

        $this->checkOwner($keluhan);

        $validated = $request->validate([
            'status' => [
                'required',
                'in:menunggu,diproses,selesai,ditolak'
            ],
        ]);

        $keluhan->update([
            'status' => $validated['status']
        ]);

        return back()->with(
            'success',
            'Status keluhan berhasil diperbarui.'
        );
    }

    private function checkOwner(
        Keluhan $keluhan
    ): void {

        abort_unless(
            $keluhan->station->id_operator ===
            auth()->user()->operator->id_operator,
            403
        );
    }
}