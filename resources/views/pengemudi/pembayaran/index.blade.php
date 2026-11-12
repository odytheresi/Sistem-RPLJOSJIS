
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Charging</title>

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
            max-width: 850px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .back {
            text-decoration: none;
            color: #2563eb;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        h2 {
            margin-top: 0;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .total {
            color: #16a34a;
            font-size: 23px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-top: 10px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        button:hover {
            background: #1d4ed8;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            color: #dc2626;
            margin-top: 10px;
        }

        .empty {
            text-align: center;
            color: #64748b;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>Pembayaran Charging</h2>

        <a href="{{ route('pengemudi.dashboard') }}" class="back">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @forelse($transaksi as $item)
        <div class="card">
            <h2>Rincian Tagihan</h2>
            <div class="detail">
                <span>Nomor Transaksi</span>
                <strong>{{ $item->id_transaksi }}</strong>
            </div>
            <div class="detail">
                <span>Nomor Sesi</span>
                <strong>{{ $item->id_sesi }}</strong>
            </div>
            <div class="detail">
                <span>Energi Digunakan</span>
                <strong>{{ number_format($item->energi_pakai, 2, ',', '.') }} kWh</strong>
            </div>
            <div class="detail">
                <span>Durasi Charging</span>
                <strong>{{ $item->durasi }} menit</strong>
            </div>
            <div class="detail">
                <span>Status Pembayaran</span>
                <strong>{{ ucfirst($item->status_byr) }}</strong>
            </div>
            <div class="detail">
                <span>Total Pembayaran</span>
                <span class="total">
                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                </span>
            </div>
            <form action="{{ route('pengemudi.pembayaran.bayar', $item->id_transaksi) }}"
                  method="POST">

                @csrf
                <label><strong>Pilih Metode Pembayaran</strong></label>

                <select name="mtd_bayar" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="DANA">DANA</option>
                    <option value="OVO">OVO</option>
                    <option value="GoPay">GoPay</option>
                    <option value="Tunai">Tunai melalui Operator</option>
                </select>

                <button type="submit">
                    Bayar Sekarang
                </button>
            </form>
        </div>
    @empty
        <div class="card empty">
            <h3>Tidak Ada Tagihan</h3>
            <p>Belum ada transaksi charging yang menunggu pembayaran.</p>
        </div>
    @endforelse
</div>
</body>
</html>
