
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 12px;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .check {
            font-size: 40px;
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
            width: 100%;
            border-collapse: collapse;
        }
        .detail td {
            padding: 12px 5px;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail td:first-child {
            color: #64748b;
            width: 45%;
        }
        .detail td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .total {
            margin-top: 25px;
            padding: 20px;
            background: #f0fdf4;
            text-align: center;
        }
        .total h1 {
            color: #16a34a;
            margin-bottom: 0;
        }
        .footer {
            margin-top: 35px;
            text-align: center;
            color: #64748b;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div class="check">✓</div>
        <h2>PEMBAYARAN BERHASIL</h2>
        <p>Terima kasih telah menggunakan layanan EV Charging.</p>
        <strong>Bukti Transaksi Pembayaran</strong>
    </div>

    <hr>
    <table class="detail">
        <tr>
            <td>Nomor Transaksi</td>
            <td>TRX-{{ $transaksi->id_transaksi }}</td>
        </tr>
        <tr>
            <td>Nomor Sesi</td>
            <td>{{ $transaksi->id_sesi }}</td>
        </tr>
        <tr>
            <td>Tanggal Pembayaran</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->wkt_byr)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td>Metode Pembayaran</td>
            <td>{{ $transaksi->mtd_bayar }}</td>
        </tr>
        <tr>
            <td>Waktu Mulai Charging</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->wkt_mulai)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td>Waktu Selesai Charging</td>
            <td>{{ \Carbon\Carbon::parse($transaksi->wkt_selesai)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td>Energi Digunakan</td>
            <td>{{ number_format($transaksi->energi_pakai, 2, ',', '.') }} kWh</td>
        </tr>
        <tr>
            <td>Durasi Charging</td>
            <td>{{ $transaksi->durasi }} menit</td>
        </tr>
        <tr>
            <td>Status Pembayaran</td>
            <td style="color: #16a34a;">Berhasil</td>
        </tr>
    </table>

    <div class="total">
        Total Pembayaran
        <h1>
            Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
        </h1>
    </div>

    <div class="footer">
        Bukti pembayaran resmi dari sistem EV Charging.
        <br>
        Harap simpan dokumen ini sebagai bukti transaksi.
    </div>
</div>
</body>
</html>
