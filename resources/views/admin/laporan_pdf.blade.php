    <div class="ringkas">
        <strong>Total Pendapatan:</strong> Rp {{ number_format($total_pendapatan ?? 0, 0, ',', '.') }}
        &nbsp;&bull;&nbsp;
        <strong>Laporan Kerusakan:</strong> {{ count($kerusakan ?? []) }}
    </div>

    <h3>Sesi Charging per Bulan</h3>
    <table>
        <thead><tr><th>Bulan</th><th class="kanan">Jumlah Sesi</th><th class="kanan">Energi (kWh)</th></tr></thead>
        <tbody>
            @forelse ($sesi_per_bulan as $r)
                <tr>
                    <td>{{ data_get($r, 'bulan') }}</td>
                    <td class="kanan">{{ data_get($r, 'jumlah_sesi') }}</td>
                    <td class="kanan">{{ number_format((float) data_get($r, 'total_kwh'), 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Pendapatan per Stasiun</h3>
    <table>
        <thead><tr><th>Stasiun</th><th class="kanan">Transaksi</th><th class="kanan">Pendapatan</th></tr></thead>
        <tbody>
            @forelse ($pendapatan_per_stasiun as $r)
                <tr>
                    <td>{{ data_get($r, 'stasiun') }}</td>
                    <td class="kanan">{{ data_get($r, 'jumlah_transaksi') }}</td>
                    <td class="kanan">Rp {{ number_format((float) data_get($r, 'total_pendapatan'), 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Riwayat Kerusakan Charger</h3>
    <table>
        <thead>
            <tr>
                <th>Stasiun</th><th>Charger</th><th>Deskripsi</th>
                <th>Dilaporkan</th><th>Selesai</th><th>Status</th><th class="kanan">Durasi (jam)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kerusakan as $r)
                <tr>
                    <td>{{ data_get($r, 'stasiun') }}</td>
                    <td>{{ data_get($r, 'charger') }}</td>
                    <td>{{ data_get($r, 'deskripsi') ?? '-' }}</td>
                    <td>{{ data_get($r, 'waktu_lapor') }}</td>
                    <td>{{ data_get($r, 'waktu_selesai') ?? '-' }}</td>
                    <td>{{ data_get($r, 'status') }}</td>
                    <td class="kanan">{{ data_get($r, 'durasi_jam') }}</td>
                </tr>
            @empty
                <tr><td colspan="7">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>