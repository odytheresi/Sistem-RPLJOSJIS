
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Transaksi</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0,0,0,.06);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .check {
            font-size: 55px;
            color: #16a34a;
        }

        .header h2 {
            color: #16a34a;
            margin-bottom: 8px;
        }

        .header p {
            color: #64748b;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 13px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail span {
            color: #64748b;
        }

        .detail strong {
            text-align: right;
        }

        .total {
            margin-top: 25px;
            padding: 20px;
            background: #f0fdf4;
            border-radius: 10px;
            text-align: center;
        }

        .total h1 {
            color: #16a34a;
            margin: 10px 0 0;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .buttons a,
        .buttons button {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .dashboard {
            background: #2563eb;
            color: white;
        }

        .print {
            background: #e2e8f0;
            color: #1e293b;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .card {
                box-shadow: none;
            }

            .buttons {
                display: none;
            }
        }

        @media (max-width: 500px) {
            body {
                padding: 15px;
            }

            .card {
                padding: 20px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="header">
            <div class="check">✓</div>
            <h2>PEMBAYARAN BERHASIL</h2>
            <p>Terima kasih telah menggunakan layanan EV Charging.</p>
            <strong>Bukti Transaksi Pembayaran</strong>
        </div>
        <hr>
        <div class="detail">
            <span>Nomor Transaksi</span>
            <strong>TRX-{{ $transaksi->id_transaksi }}</strong>
        </div>
        <div class="detail">
            <span>Nomor Sesi</span>
            <strong>{{ $transaksi->id_sesi }}</strong>
        </div>
        <div class="detail">
            <span>Tanggal Pembayaran</span>
            <strong>
                {{ \Carbon\Carbon::parse($transaksi->wkt_byr)->format('d-m-Y H:i') }}
            </strong>
        </div>
        <div class="detail">
            <span>Metode Pembayaran</span>
            <strong>{{ $transaksi->mtd_bayar }}</strong>
        </div>
        <div class="detail">
            <span>Waktu Mulai Charging</span>
            <strong>{{ \Carbon\Carbon::parse($transaksi->wkt_mulai)->format('d-m-Y H:i') }}</strong>
        </div>
        <div class="detail">
            <span>Waktu Selesai Charging</span>
            <strong>{{ \Carbon\Carbon::parse($transaksi->wkt_selesai)->format('d-m-Y H:i') }}</strong>
        </div>
        <div class="detail">
            <span>Energi Digunakan</span>
            <strong>
                {{ number_format($transaksi->energi_pakai, 2, ',', '.') }} kWh
            </strong>
        </div>
        <div class="detail">
            <span>Durasi Charging</span>
            <strong>{{ $transaksi->durasi }} menit</strong>
        </div>
        <div class="detail">
            <span>Status Pembayaran</span>
            <strong style="color: #16a34a;">Berhasil</strong>
        </div>
        <div class="total">
            <span>Total Pembayaran</span>
            <h1>
                Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
            </h1>
        </div>
        <div class="buttons">
            <a href="{{ route('pengemudi.dashboard') }}"
               class="dashboard">
                Kembali ke Dashboard
            </a>
            <a href="{{ route('pengemudi.pembayaran.bukti.pdf', $transaksi->id_transaksi) }}"
                class="print">
                📄 Cetak Bukti PDF
            </a>
        </div>
    </div>
</div>
</body>
</html>
