<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use App\Models\Operator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeluhanController extends Controller
{
    public function index(): View
    {
        $this->currentOperator();

        $keluhan = Keluhan::with('station')
            ->latest()
            ->get();

        return view(
            'operator.keluhan.index',
            compact('keluhan')
        );
    }

    public function show(Keluhan $keluhan): View
    {
        $this->currentOperator();

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

        $this->currentOperator();

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

    /**
     * Memastikan yang login adalah operator.
     */
    private function currentOperator(): Operator
    {
        $operator = Operator::where('id_user', auth()->user()->id_user)->first();

        if (!$operator) {
            throw new HttpResponseException(
                redirect('/login')->withErrors([
                    'login' => 'Silakan login sebagai operator terlebih dahulu.',
                ])
            );
        }

        return $operator;
    }
}