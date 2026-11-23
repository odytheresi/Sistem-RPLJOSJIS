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
        $operator = $this->currentOperator();

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

    private function checkOwner(
        Keluhan $keluhan
    ): void {

        abort_unless(
            (int) $keluhan->station->id_operator ===
            (int) $this->currentOperator()->id_operator,
            403
        );
    }
}