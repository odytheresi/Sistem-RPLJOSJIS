<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h1 { color: #133968; font-size: 18px; margin: 0 0 4px; }
        h3 { color: #133968; font-size: 13px; margin: 18px 0 6px; }
        .sub { color: #666; margin-bottom: 14px; }
        .ringkas { background: #E6F3F6; padding: 8px 10px; border-left: 4px solid #3D9E71; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #133968; color: #fff; text-align: left; padding: 6px 8px; }
        td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) td { background: #F6FBFC; }
        .kanan { text-align: right; }
        .footer { margin-top: 20px; font-size: 9px; color: #888; }
    </style>
</head>
<body>
    <h1>Laporan Aktivitas Sistem</h1>
    <div class="sub">EV ChargeHub &bull; Periode {{ $periode['dari'] }} s/d {{ $periode['sampai'] }}</div>

    <div class="ringkas"><strong>Total Aktivitas:</strong> {{ $total_aktivitas ?? 0 }}</div>

    <h3>Aktivitas per Jenis</h3>
    <table>
        <thead><tr><th>Aktivitas</th><th class="kanan">Jumlah</th></tr></thead>
        <tbody>
            @forelse ($per_aktivitas as $r)
                <tr><td>{{ data_get($r, 'aktivitas') }}</td><td class="kanan">{{ data_get($r, 'total') }}</td></tr>
            @empty
                <tr><td colspan="2">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>User Teraktif</h3>
    <table>
        <thead><tr><th>User</th><th class="kanan">Jumlah</th></tr></thead>
        <tbody>
            @forelse ($user_teraktif as $r)
                <tr>
                    <td>{{ data_get($r, 'user.identifier') ?? data_get($r, 'id_user') ?? '-' }}</td>
                    <td class="kanan">{{ data_get($r, 'total') }}</td>
                </tr>
            @empty
                <tr><td colspan="2">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Aktivitas per Hari</h3>
    <table>
        <thead><tr><th>Tanggal</th><th class="kanan">Jumlah</th></tr></thead>
        <tbody>
            @forelse ($per_hari as $r)
                <tr><td>{{ data_get($r, 'tanggal') }}</td><td class="kanan">{{ data_get($r, 'total') }}</td></tr>
            @empty
                <tr><td colspan="2">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak pada {{ now()->format('d-m-Y H:i') }}</div>
</body>
</html>