<?php

namespace App\Http\Controllers\Pengemudi;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class KendaraanController extends Controller
{
    // Menampilkan daftar kendaraan milik pengemudi
    public function index()
    {
        $pengemudi = Auth::guard('pengemudi')->user();

        $kendaraans = Kendaraan::where(
            'user_id',
            $pengemudi->user_id
        )->get();

        return view(
            'kendaraan.index',
            compact('kendaraans')
        );
    }

    // Menampilkan form tambah kendaraan
    public function create()
    {
        return view('kendaraan.create');
    }

    // Menyimpan kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'no_plat' => 'required|string|max:15|unique:kendaraans,no_plat',
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'kapasitas_baterai' => 'required|numeric|min:0.01|max:999999.99',
        ]);

        $pengemudi = Auth::guard('pengemudi')->user();

        Kendaraan::create([
            'user_id' => $pengemudi->user_id,
            'no_plat' => $request->no_plat,
            'merk' => $request->merk,
            'model' => $request->model,
            'kapasitas_baterai' => $request->kapasitas_baterai,
        ]);

        return redirect()
            ->route('pengemudi.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    // Menampilkan form edit kendaraan
    public function edit($id)
    {
        $pengemudi = Auth::guard('pengemudi')->user();

        $kendaraan = Kendaraan::where('user_id', $pengemudi->user_id)
            ->findOrFail($id);

        return view('kendaraan.edit', compact('kendaraan'));
    }

    // Menyimpan perubahan kendaraan
    public function update(Request $request, $id)
    {
        $pengemudi = Auth::guard('pengemudi')->user();

        $kendaraan = Kendaraan::where('user_id', $pengemudi->user_id)
            ->findOrFail($id);

        $request->validate([
            'no_plat' => 'required|string|max:15|unique:kendaraans,no_plat,' . $kendaraan->id_kendaraan . ',id_kendaraan',
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'kapasitas_baterai' => 'required|numeric|min:0.01|max:999999.99',
        ]);

        $kendaraan->update($request->only([
            'no_plat',
            'merk',
            'model',
            'kapasitas_baterai',
        ]));

        return redirect()
            ->route('pengemudi.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    // Menghapus kendaraan
    public function destroy($id)
    {
        $pengemudi = Auth::guard('pengemudi')->user();

        $kendaraan = Kendaraan::where('user_id', $pengemudi->user_id)
            ->findOrFail($id);

        $kendaraan->delete();

        return redirect()
            ->route('pengemudi.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}