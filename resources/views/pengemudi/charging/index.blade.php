<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charging Kendaraan</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 25px;
            font-family: Arial, sans-serif;
            background: #f5f6df;
            color: #172b3a;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .header {
            margin-bottom: 25px;
        }
        .header a {
            color: #147d70;
            text-decoration: none;
        }
        h1 {
            margin-bottom: 8px;
        }
        .info {
            color: #657078;
        }
        .section {
            margin-bottom: 30px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(250px, 1fr)
            );
            gap: 18px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }
        .card h3 {
            margin-top: 0;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #d7f8e3;
            color: #147d42;
            font-size: 13px;
        }
        .badge.busy {
            background: #ffe4df;
            color: #b42318;
        }
        .empty {
            padding: 20px;
            background: white;
            border-radius: 12px;
            color: #657078;
        }
        .button {
            display: inline-block;
            padding: 12px 18px;
            background: #147d70;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
        }
        .button:hover {
            background: #10665c;
        }
        .button:disabled {
            background: #a0aaa8;
            cursor: not-allowed;
        }
        .price {
            font-size: 20px;
            font-weight: bold;
            color: #147d70;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: white;
            color: #147d70;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            transition: 0.2s;
        }
        .btn-back:hover {
            background: #147d70;
            color: white;
        }
        .back-icon {
            font-size: 22px;
            line-height: 1;
        }
        /* Form Charging */
        .form-card {
            max-width: 650px;
            margin-top: 25px;
        }
        .field {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 9px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: white;
            color: #172b3a;
            font-size: 14px;
        }
        input:focus {
            outline: none;
            border-color: #147d70;
        }
        .btn-start {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            margin-top: 5px;
        }
        .notice {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #d7f8e3;
            color: #147d42;
        }
        .error {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #ffe4df;
            color: #b42318;
        }
        .error ul {
            margin-bottom: 0;
        }
        /* Pilihan Kendaraan dan Charger */
        .pilihan-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .pilihan-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 18px;
            cursor: pointer;
            transition: 0.2s;
        }
        .pilihan-card:hover {
            border-color: #159781;
            transform: translateY(-2px);
        }
        .pilihan-card.terpilih {
            border: 2px solid #159781;
            background: #e8f7f3;
        }
        .status-tersedia {
            color: green;
            font-weight: bold;
        }
        .btn-mulai {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #117f70;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-mulai:hover {
            background: #10665c;
        }
        .btn-mulai:disabled {
            background: #999;
            cursor: not-allowed;
        }
        .btn-akhiri {
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            background: #b42318;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-akhiri:hover {
            background: #941b12;
        }
        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
            .pilihan-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    {{-- Header --}}
    <div class="header">
        <a href="{{ route('pengemudi.dashboard') }}"
           class="btn-back">
            <span class="back-icon">←</span>
            Kembali ke Dashboard
        </a>
        <h1>Charging Kendaraan ⚡</h1>
        @if ($sesiAktif)
            <p class="info">
                Pantau proses pengisian daya kendaraan Anda.
            </p>
        @else
            <p class="info">
                Pilih kendaraan dan lihat charger yang tersedia.
            </p>
        @endif
    </div>
    
    {{-- Notifikasi Berhasil --}}
    @if (session('success'))
        <div class="notice">
            {{ session('success') }}
        </div>
    @endif

    {{-- Rincian Biaya Charging --}}
    @if (session('receipt'))
        @php
            $receipt = session('receipt');
        @endphp
        <div class="card section">
            <h2>Rincian Charging ⚡</h2>
            <p>
                Nomor Sesi:
                <strong>{{ $receipt['id_sesi'] }}</strong>
            </p>
            <p>
                Energi Digunakan:
                <strong>{{ number_format($receipt['energi'], 2, ',', '.') }} kWh</strong>
            </p>
            <p>
                Tarif Listrik:
                <strong>
                    Rp{{ number_format($receipt['tarif'], 0, ',', '.') }}/kWh
                </strong>
            </p>
            <p>
                Durasi Charging:
                <strong>{{ $receipt['durasi'] }} menit</strong>
            </p>
            <hr>
            <h3>Total Biaya</h3>
            <div class="price">
                Rp{{ number_format($receipt['total_bayar'], 0, ',', '.') }}
            </div>
            <p class="info">
                Biaya dihitung berdasarkan energi yang digunakan
                dikalikan tarif listrik per kWh.
            </p>
        </div>
    @endif

    {{-- Pesan Error --}}
    @if ($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- Sesi Charging Aktif --}}
    @if ($sesiAktif)
        <div class="section card" id="chargingAktif"
            data-target="{{ $sesiAktif->energi_pakai }}">

            <h3>Charging Sedang Berlangsung ⚡</h3>
            <p>
                Nomor Sesi:
                <strong>{{ $sesiAktif->id_sesi }}</strong>
            </p>

            <p>
                Status:
                <span class="badge" id="statusCharging">
                    {{ ucfirst($sesiAktif->status) }}
                </span>
            </p>

            <h3>Progres Pengisian 🔋</h3>
            <div style="background:#e5e7eb; border-radius:20px; height:18px; overflow:hidden;">
                <div id="progressCharging"
                    style="width:0%; height:100%; background:#16a34a; transition:width 1s;">
                </div>
            </div>

            <h2 id="persentaseCharging">0%</h2>
            <p>
                Energi Terisi:
                <strong id="energiTerisi">0.00 kWh</strong>
                /
                {{ number_format($sesiAktif->energi_pakai, 2) }} kWh
            </p>

            <p class="info">
                Progres pengisian ini merupakan simulasi.
            </p>
        </div>

        {{-- Form Akhiri Charging --}}
    <form action="{{ route('pengemudi.charging.end') }}"
        method="POST"
        class="section"
        id="formAkhiriCharging">

        @csrf

        {{-- Menyimpan energi aktual dari progres charging --}}
        <input type="hidden"
            name="energi_terisi"
            id="inputEnergiTerisi"
            value="0">

        <button type="submit"
            class="btn-akhiri"
            onclick="return confirm('Apakah Anda yakin ingin mengakhiri charging?')">
            Akhiri Charging
        </button>
    </form>

    @endif

    {{-- Form Mulai Charging --}}
    @if (!$sesiAktif && $kendaraans->count() > 0)
        <form
            action="{{ route('pengemudi.charging.start') }}"
            method="POST"
            id="formCharging">
            @csrf
            {{-- Input ID Kendaraan dan Charger --}}
            <input
                type="hidden"
                name="id_kendaraan"
                id="id_kendaraan" >

            <input
                type="hidden"
                name="id_charger"
                id="id_charger" >
            {{-- Pilih Kendaraan --}}
            <h2>Pilih Kendaraan 🚗</h2>
            <div class="pilihan-container">
                @foreach ($kendaraans as $kendaraan)
                    <div
                        class="pilihan-card kendaraan"
                        onclick="pilihKendaraan(this, '{{ $kendaraan->id_kendaraan }}')">
                        <h3>
                            {{ $kendaraan->merk }}
                            {{ $kendaraan->model }}
                        </h3>
                        <p>
                            Nomor Polisi:
                            {{ $kendaraan->no_plat }}
                        </p>
                        <p>
                            Kapasitas Baterai:
                            {{ $kendaraan->kapasitas_baterai }} kWh
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Pilih Charger --}}
            <h2>Pilih Charger ⚡</h2>
            <div class="pilihan-container">
                @foreach ($chargers as $charger)
                    @if ($charger->tarif && !$charger->sedang_digunakan)

                        <div
                            class="pilihan-card charger"
                            onclick="pilihCharger(this, '{{ $charger->id_charger }}')">
                            <h3>
                                {{ $charger->kd_charger }}
                            </h3>
                            <p>
                                {{ $charger->nama_st }}
                            </p>
                            <p>
                                Daya: {{ $charger->daya_maks }} kW
                            </p>
                            <p>
                                Tarif: Rp{{ number_format(
                                    $charger->tarif->harga_per_kwh,
                                    0,
                                    ',',
                                    '.'
                                ) }}/kWh
                            </p>
                            <span class="status-tersedia">
                                Tersedia
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="section card">
                <h2>Target Energi Charging 🔋</h2>

                <div class="field">
                    <label>Energi yang Ingin Diisi (kWh)</label>
                    <input
                        type="number"
                        name="energi_pakai"
                        step="0.01"
                        min="0.01"
                        placeholder="Contoh: 20"
                        required >
                    <p class="info">
                        Masukkan jumlah energi yang ingin diisi sebelum memulai charging.
                    </p>
                </div>
            </div>
            {{-- Tombol Mulai Charging --}}
            <button
                type="submit"
                class="btn-mulai">
                ⚡ Mulai Charging
            </button>
        </form>
    @endif
</div>

{{-- JavaScript --}}
<script>
    let kendaraanDipilih = false;
    let chargerDipilih = false;
    // Fungsi Memilih Kendaraan
    function pilihKendaraan(element, id) {
        document.querySelectorAll('.pilihan-card.kendaraan')
            .forEach(card => {
                card.classList.remove('terpilih');
            });
        element.classList.add('terpilih');
        document.getElementById('id_kendaraan').value = id;
        kendaraanDipilih = true;
    }
    // Fungsi Memilih Charger
    function pilihCharger(element, id) {
        document.querySelectorAll('.pilihan-card.charger')
            .forEach(card => {
                card.classList.remove('terpilih');
            });
        element.classList.add('terpilih');
        document.getElementById('id_charger').value = id;
        chargerDipilih = true;
    }
    // Validasi Form Charging
    document.addEventListener('DOMContentLoaded', function () {
        const formCharging = document.getElementById('formCharging');
        if (formCharging) {
            formCharging.addEventListener('submit', function(e) {
                if (!kendaraanDipilih || !chargerDipilih) {
                    e.preventDefault();
                    alert('Silakan pilih kendaraan dan charger terlebih dahulu!');
                }
            });
        }
    });

    // Simulasi progres charging
    document.addEventListener('DOMContentLoaded', function () {
        const charging = document.getElementById('chargingAktif');
        if (!charging) return;
        const target = parseFloat(charging.dataset.target);
        if (!target || target <= 0) return;
        const progressBar = document.getElementById('progressCharging');
        const persentase = document.getElementById('persentaseCharging');
        const energiTerisi = document.getElementById('energiTerisi');
        const status = document.getElementById('statusCharging');
        const inputEnergi = document.getElementById('inputEnergiTerisi');
        let progres = 0;
        const interval = setInterval(function () {
            progres += 1;
            if (progres >= 100) {
                progres = 100;
                clearInterval(interval);
                status.textContent = 'Target Tercapai';
            }

            // Hitung energi berdasarkan persentase progres
            const energi = target * progres / 100;
            progressBar.style.width = progres + '%';
            persentase.textContent = progres + '%';
            energiTerisi.textContent = energi.toFixed(2) + ' kWh';

            // Simpan nilai energi aktual untuk dikirim ke controller
            if (inputEnergi) {
                inputEnergi.value = energi.toFixed(2);
            }
        }, 1000);
    });
</script>
</body>
</html>
