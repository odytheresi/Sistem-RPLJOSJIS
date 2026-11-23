<?php

namespace App\Http\Controllers;

use App\Models\TipeKonektor;
use Illuminate\Http\Request;

class TipeKonektorController extends Controller
{
   
    public function index()
    {
        $konektors = TipeKonektor::all();

        return view(
            'operator.konektor.index',
            compact('konektors')
        );
    }

    
    public function create()
    {
        return view('operator.konektor.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'nm_konektor' => 'required|string|max:155',
            'jenis_charging' => 'required|in:AC Type 2,DC Fast Charging',
        ]);

        TipeKonektor::create([
            'nm_konektor' => $request->nm_konektor,
            'jenis_charging' => $request->jenis_charging,
        ]);

        return redirect()
            ->route('operator.konektor.index')
            ->with(
                'success',
                'Tipe konektor berhasil ditambahkan.'
            );
    }

    
    public function edit($id)
    {
        $konektor = TipeKonektor::findOrFail($id);

        return view(
            'operator.konektor.edit',
            compact('konektor')
        );
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nm_konektor' => 'required|string|max:155',
            'jenis_charging' => 'required|in:AC Type 2,DC Fast Charging',
        ]);

        $konektor = TipeKonektor::findOrFail($id);

        $konektor->update([
            'nm_konektor' => $request->nm_konektor,
            'jenis_charging' => $request->jenis_charging,
        ]);

        return redirect()
            ->route('operator.konektor.index')
            ->with(
                'success',
                'Tipe konektor berhasil diperbarui.'
            );
    }

    
    public function destroy($id)
    {
        $konektor = TipeKonektor::findOrFail($id);

        $konektor->delete();

        return redirect()
            ->route('operator.konektor.index')
            ->with(
                'success',
                'Tipe konektor berhasil dihapus.'
            );
    }
}