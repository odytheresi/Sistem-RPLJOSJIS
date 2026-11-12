<?php
namespace App\Http\Controllers\Pengemudi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChargingController extends Controller
{
    // ==========================================
    // HALAMAN UTAMA CHARGING
    // ==========================================
    public function index()
    {
        $userId = Auth::guard('pengemudi')->id();

        if (!$userId) {
            return redirect()->route('pengemudi.login');
        }

        // Ambil kendaraan milik pengemudi
        $kendaraans = DB::table('kendaraans')
            ->where('user_id', $userId)
            ->get();

        // Ambil charger aktif dari stasiun aktif
        $chargers = DB::table('charger as c')
            ->join(
                'charging_station as st',
                'c.id_station',
                '=',
                'st.id_station'
            )
            ->where('c.status', 'aktif')
            ->where('st.status', 'aktif')
            ->select(
                'c.id_charger',
                'c.id_station',
                'c.kd_charger',
                'c.daya_maks',
                'c.status',
                'st.nama_st',
                'st.alamat'
            )
            ->get();

        // Ambil tarif dan status setiap charger
        foreach ($chargers as $charger) {

            $charger->tarif = DB::table('tarif')
                ->where('id_station', $charger->id_station)
                ->where('status', 'aktif')
                ->where('berlaku_mulai', '<=', now())
                ->orderByDesc('berlaku_mulai')
                ->first();

            $charger->sedang_digunakan = DB::table('sesi_charger')
                ->where('id_charger', $charger->id_charger)
                ->whereIn('status', ['menunggu', 'berlangsung'])
                ->exists();
        }

        // Ambil sesi charging aktif milik pengemudi
        $sesiAktif = DB::table('sesi_charger')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'berlangsung'])
            ->orderByDesc('id_sesi')
            ->first();

        return view('pengemudi.charging.index', compact(
            'kendaraans',
            'chargers',
            'sesiAktif'
        ));
    }


    // ==========================================
    // MEMULAI CHARGING
    // ==========================================
    public function start(Request $request)
    {
        $request->validate([
            'id_kendaraan' => 'required|integer',
            'id_charger' => 'required|integer',
            'energi_pakai' => 'required|numeric|min:0.01',
        ]);

        $userId = Auth::guard('pengemudi')->id();

        // Pastikan kendaraan milik pengemudi
        $kendaraan = DB::table('kendaraans')
            ->where('id_kendaraan', $request->id_kendaraan)
            ->where('user_id', $userId)
            ->first();

        if (!$kendaraan) {
            return back()->withErrors([
                'id_kendaraan' => 'Kendaraan tidak valid.'
            ]);
        }

        // Periksa charger yang dipilih
        $charger = DB::table('charger as c')
            ->join(
                'charging_station as st',
                'c.id_station',
                '=',
                'st.id_station'
            )
            ->where('c.id_charger', $request->id_charger)
            ->where('c.status', 'aktif')
            ->where('st.status', 'aktif')
            ->select('c.*', 'st.nama_st')
            ->first();

        if (!$charger) {
            return back()->withErrors([
                'id_charger' => 'Charger tidak tersedia.'
            ]);
        }

        // Periksa sesi aktif pengemudi
        $sesiAktif = DB::table('sesi_charger')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'berlangsung'])
            ->exists();

        if ($sesiAktif) {
            return back()->withErrors([
                'charging' => 'Selesaikan sesi charging sebelumnya.'
            ]);
        }

        // Periksa apakah charger sedang digunakan
        $chargerDigunakan = DB::table('sesi_charger')
            ->where('id_charger', $charger->id_charger)
            ->whereIn('status', ['menunggu', 'berlangsung'])
            ->exists();

        if ($chargerDigunakan) {
            return back()->withErrors([
                'id_charger' => 'Charger sedang digunakan.'
            ]);
        }

        // Ambil tarif aktif
        $tarif = DB::table('tarif')
            ->where('id_station', $charger->id_station)
            ->where('status', 'aktif')
            ->where('berlaku_mulai', '<=', now())
            ->orderByDesc('berlaku_mulai')
            ->first();

        if (!$tarif) {
            return back()->withErrors([
                'id_charger' => 'Tarif charger belum tersedia.'
            ]);
        }

        // Simpan sesi charging
        $energi = (float) $request->energi_pakai;
        $idSesi = DB::table('sesi_charger')->insertGetId([
            'user_id' => $userId,
            'id_charger' => $charger->id_charger,
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'id_tarif' => $tarif->id_tarif,
            'wkt_mulai' => now(),
            'energi_pakai' => $energi,
            'durasi' => 0,
            'total_bayar' => 0,
            'status' => 'berlangsung',
        ]);

        return redirect()
            ->route('pengemudi.charging.index')
            ->with(
                'success',
                'Charging berhasil dimulai! Nomor sesi: ' . $idSesi
            );
    }

    
// ==========================================
// MENGAKHIRI CHARGING DAN MENGHITUNG BIAYA
// ==========================================
public function end(Request $request)
{
    $request->validate([
        'energi_terisi' => 'required|numeric|min:0',
    ]);

    $userId = Auth::guard('pengemudi')->id();

    $sesi = DB::table('sesi_charger')
        ->where('user_id', $userId)
        ->where('status', 'berlangsung')
        ->orderByDesc('id_sesi')
        ->first();

    if (!$sesi) {
        return back()->withErrors([
            'charging' => 'Tidak ada sesi charging yang sedang berlangsung.'
        ]);
    }

    $tarif = DB::table('tarif')
        ->where('id_tarif', $sesi->id_tarif)
        ->first();

    if (!$tarif) {
        return back()->withErrors([
            'charging' => 'Data tarif tidak ditemukan.'
        ]);
    }

    // Ambil energi aktual dari progres charging
    $energi = (float) $request->energi_terisi;

    // Pastikan energi aktual tidak melebihi target
    $targetEnergi = (float) $sesi->energi_pakai;

    if ($energi > $targetEnergi) {
        return back()->withErrors([
            'charging' => 'Energi terisi tidak boleh melebihi target.'
        ]);
    }

    $waktuSelesai = now();

    $durasi = (int) Carbon::parse($sesi->wkt_mulai)
        ->diffInMinutes($waktuSelesai);

    $hargaPerKwh = (float) $tarif->harga_per_kwh;

    // Hitung pembayaran berdasarkan energi aktual
    $totalBayar = round($energi * $hargaPerKwh, 2);

    DB::transaction(function () use (
        $sesi,
        $waktuSelesai,
        $energi,
        $durasi,
        $totalBayar
    ) {
        DB::table('sesi_charger')
            ->where('id_sesi', $sesi->id_sesi)
            ->update([
                'wkt_selesai' => $waktuSelesai,
                'energi_pakai' => $energi,
                'durasi' => $durasi,
                'total_bayar' => $totalBayar,
                'status' => 'selesai',
            ]);

        DB::table('transaksi')->insert([
            'id_sesi' => $sesi->id_sesi,
            'mtd_bayar' => 'Belum dipilih',
            'jumlah' => $totalBayar,
            'status_byr' => 'menunggu',
            'wkt_byr' => $waktuSelesai,
        ]);
    });

    return redirect()
        ->route('pengemudi.pembayaran.index')
        ->with(
            'success',
            'Charging berhasil diakhiri! Silakan lakukan pembayaran.'
        );
    }
}
