<?php

namespace App\Http\Controllers\Pengemudi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('pengemudi')->id();
        $transaksi = DB::table('transaksi as t')
            ->join('sesi_charger as s', 't.id_sesi', '=', 's.id_sesi')
            ->where('s.user_id', $userId)
            ->where('t.status_byr', 'menunggu')
            ->select('t.*', 's.energi_pakai', 's.durasi')
            ->orderByDesc('t.id_transaksi')
            ->get();
        return view('pengemudi.pembayaran.index', compact('transaksi'));
    }
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'mtd_bayar' => 'required|in:Transfer Bank,DANA,OVO,GoPay,Tunai',
        ]);
        $userId = Auth::guard('pengemudi')->id();
        $transaksi = DB::table('transaksi as t')
            ->join('sesi_charger as s', 't.id_sesi', '=', 's.id_sesi')
            ->where('t.id_transaksi', $id)
            ->where('s.user_id', $userId)
            ->where('t.status_byr', 'menunggu')
            ->select('t.id_transaksi')
            ->first();
        if (!$transaksi) {
            return back()->withErrors([
                'pembayaran' => 'Transaksi tidak ditemukan atau sudah dibayar.'
            ]);
        }
        DB::table('transaksi')
            ->where('id_transaksi', $id)
            ->update([
                'mtd_bayar' => $request->mtd_bayar,
                'status_byr' => 'berhasil',
                'wkt_byr' => now(),
            ]);
        return redirect()->route(
            'pengemudi.pembayaran.bukti',
            ['id' => $id]
        );
    }
    public function bukti($id)
    {
        $userId = Auth::guard('pengemudi')->id();
        $transaksi = DB::table('transaksi as t')
            ->join('sesi_charger as s', 't.id_sesi', '=', 's.id_sesi')
            ->where('t.id_transaksi', $id)
            ->where('s.user_id', $userId)
            ->where('t.status_byr', 'berhasil')
            ->select(
                't.*',
                's.energi_pakai',
                's.durasi',
                's.wkt_mulai',
                's.wkt_selesai'
            )
            ->first();
        if (!$transaksi) {
            abort(404, 'Bukti transaksi tidak ditemukan.');
        }
        return view('pengemudi.pembayaran.bukti', compact('transaksi'));
    }

    // Cetak atau unduh bukti pembayaran dalam bentuk PDF
    public function cetakBukti($id)
    {
        $userId = Auth::guard('pengemudi')->id();
        $transaksi = DB::table('transaksi as t')
            ->join('sesi_charger as s', 't.id_sesi', '=', 's.id_sesi')
            ->where('t.id_transaksi', $id)
            ->where('s.user_id', $userId)
            ->where('t.status_byr', 'berhasil')
            ->select(
                't.*',
                's.energi_pakai',
                's.durasi',
                's.wkt_mulai',
                's.wkt_selesai'
            )
            ->first();
        if (!$transaksi) {
            abort(404, 'Bukti transaksi tidak ditemukan.');
        }
        $pdf = Pdf::loadView(
            'pengemudi.pembayaran.bukti-pdf',
            compact('transaksi')
        )->setPaper('a4', 'portrait');
        return $pdf->download(
            'Bukti-Pembayaran-TRX-' . $transaksi->id_transaksi . '.pdf'
        );
    }
}