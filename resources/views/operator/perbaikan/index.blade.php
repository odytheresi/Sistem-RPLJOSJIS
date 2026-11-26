<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Charger - EVChargeHub</title>
    <style>
    :root { --green: #3d9e71; --green-dark: #2f7d59; --green-soft: #e0f1e8; --text: #172033; --muted: #8390a5; --line: #e7ecf3; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; color: var(--text); display: flex; min-height: 100vh; font-size: 14px; }
    a { color: var(--green); text-decoration: none; }

    /* ===== SIDEBAR ===== */
    .sidebar { width: 240px; background: linear-gradient(180deg, #3d9e71, #2a7352); color: #fff; padding: 24px 16px; flex-shrink: 0; }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a {
        display: block; color: #e6f5ed; padding: 12px 14px; border-radius: 10px;
        margin-bottom: 10px; font-size: 14px; background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18); transition: background 0.2s, transform 0.2s;
    }
    .sidebar nav a:hover { background: rgba(255, 255, 255, 0.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active { background: rgba(255, 255, 255, 0.28); border-color: rgba(255, 255, 255, 0.5); color: #fff; font-weight: 700; }

    /* ===== MAIN & TOPBAR ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
    .topbar h2 { font-size: 22px; font-weight: 800; }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .actions { display: flex; gap: 6px; align-items: center; flex-wrap: nowrap; }
    .actions form { margin: 0; display: inline; }

    /* ===== BUTTON & ALERT ===== */
    .btn {
        display: inline-block; padding: 9px 16px; border-radius: 9px; border: 1px solid transparent;
        font-size: 12px; font-weight: 700; font-family: inherit; cursor: pointer;
        background: var(--green); color: #fff; transition: .2s;
    }
    .btn:hover { background: var(--green-dark); transform: translateY(-2px); color: #fff; }
    .btn-light { background: #fff; color: var(--text); border-color: var(--line); }
    .btn-light:hover { background: #f1f5f9; color: var(--text); }
    .btn-danger { background: #fff; color: #dc2626; border-color: #fecaca; }
    .btn-danger:hover { background: #dc2626; color: #fff; }
    .btn-sm { padding: 6px 11px; font-size: 11px; }
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }

    /* ===== PANEL & TOOLBAR ===== */
    .dashboard-panel { background: white; border: 1px solid var(--line); border-radius: 15px; overflow: hidden; margin-bottom: 22px; }
    .toolbar {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap; padding: 16px 20px; border-bottom: 1px solid #edf0f5;
    }
    .chips { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip {
        display: inline-flex; align-items: center; gap: 7px; padding: 7px 12px; border-radius: 999px;
        border: 1px solid var(--line); background: #fff; color: #475569; cursor: pointer;
        font-size: 12px; font-weight: 700; font-family: inherit; transition: .2s;
    }
    .chip:hover { border-color: #a6d8bf; color: var(--text); }
    .chip.active { border-color: var(--green); background: var(--green-soft); color: var(--green-dark); box-shadow: 0 0 0 3px #3d9e7118; }
    .chip .n { min-width: 22px; padding: 1px 7px; border-radius: 10px; background: #f1f5f9; color: #64748b; font-size: 11px; text-align: center; }
    .chip.active .n { background: #fff; color: var(--green-dark); }
    .dot { width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; }
    .dot.dijadwalkan { background: #94a3b8; }
    .dot.proses { background: #3b82f6; }
    .dot.selesai { background: #22c55e; }

    .search { display: flex; align-items: center; gap: 12px; }
    .search input {
        width: 260px; max-width: 100%; padding: 9px 13px; border: 1px solid var(--line); border-radius: 10px;
        font-size: 12px; font-family: inherit; outline: none; background: #fff; color: var(--text); transition: .2s;
    }
    .search input:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .search .count { font-size: 11px; color: var(--muted); white-space: nowrap; }

    /* ===== TABLE ===== */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap; }
    th { padding: 13px 18px; text-align: left; background: #f8fafc; color: #78869b; font-weight: 700; border-bottom: 1px solid #edf0f5; }
    td { padding: 14px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    td strong { color: var(--text); }
    .hint { color: #98a2b3; font-size: 11px; display: block; margin-top: 2px; }
    .hint.late { color: #b91c1c; font-weight: 700; }
    .empty { text-align: center; color: #98a2b3; padding: 40px 20px !important; font-size: 13px; }
    .empty h4 { color: var(--text); font-size: 14px; margin: 8px 0 4px; }

    /* ===== BADGE ===== */
    .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #f1f5f9; color: #64748b; text-transform: capitalize; }
    .badge-menunggu { background: #ffedd5; color: #9a3412; }
    .badge-diproses, .badge-proses { background: #dbeafe; color: #1d4ed8; }
    .badge-selesai { background: #dcfce7; color: #166534; }
    .badge-ditolak, .badge-dibatalkan { background: #fee2e2; color: #b91c1c; }
    .badge-dijadwalkan { background: #e2e8f0; color: #475569; }

    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
    @media (max-width: 640px) { .search, .search input { width: 100%; } }
</style>
</head>
<body>
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ route('operator.keluhan.index') }}">📝 Keluhan</a>
            <a href="{{ route('operator.perbaikan.index') }}" class="active">📈 Maintenance</a>
        </nav>
    </aside>

    @php
        $total       = $perbaikan->count();
        $dijadwalkan = $perbaikan->where('status', 'dijadwalkan')->count();
        $proses      = $perbaikan->where('status', 'proses')->count();
        $selesai     = $perbaikan->where('status', 'selesai')->count();
    @endphp

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Maintenance Charger</h2>
                <p>Kelola jadwal dan riwayat perawatan charger pada stasiun Anda.</p>
            </div>
            <a href="{{ route('operator.perbaikan.create') }}" class="btn">+ Jadwalkan Maintenance</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <section class="dashboard-panel">

            {{-- Ringkasan sekaligus filter status + pencarian cepat (di halaman) --}}
            <div class="toolbar">
                <div class="chips" id="chips">
                    <button type="button" class="chip active" data-filter="semua">Semua <span class="n">{{ $total }}</span></button>
                    <button type="button" class="chip" data-filter="dijadwalkan"><span class="dot dijadwalkan"></span>Dijadwalkan <span class="n">{{ $dijadwalkan }}</span></button>
                    <button type="button" class="chip" data-filter="proses"><span class="dot proses"></span>Dalam Proses <span class="n">{{ $proses }}</span></button>
                    <button type="button" class="chip" data-filter="selesai"><span class="dot selesai"></span>Selesai <span class="n">{{ $selesai }}</span></button>
                </div>
                <div class="search">
                    <span class="count" id="rowCount">{{ $total }} jadwal</span>
                    <input type="text" id="searchMaintenance" placeholder="🔍 Cari charger, stasiun, jenis...">
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Charger</th>
                            <th>Jenis Maintenance</th>
                            <th>Tanggal Jadwal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perbaikan as $item)
                            @php
                                $tglJadwal = \Carbon\Carbon::parse($item->tgl_jadwal);
                                $terlambat = $item->status === 'dijadwalkan' && $tglJadwal->lt(today());
                            @endphp
                            <tr class="maint-row" data-status="{{ $item->status }}"
                                data-search="{{ strtolower(($item->charger->kd_charger ?? '') . ' ' . ($item->charger->station->nama_st ?? '') . ' ' . ($item->charger->konektor->nm_konektor ?? '') . ' ' . $item->jenis_maintenance . ' ' . $item->status) }}">
                                <td>
                                    <strong>{{ $item->charger->kd_charger ?? '-' }}</strong>
                                    <span class="hint">{{ $item->charger->station->nama_st ?? '-' }} · {{ $item->charger->konektor->nm_konektor ?? '-' }}</span>
                                </td>
                                <td>{{ $item->jenis_maintenance }}</td>
                                <td>
                                    {{ $tglJadwal->format('d M Y') }}
                                    @if ($terlambat)
                                        <span class="hint late">Terlambat</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $item->status }}">{{ $item->status }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('operator.perbaikan.show', $item) }}" class="btn btn-light btn-sm">Detail</a>
                                        <a href="{{ route('operator.perbaikan.edit', $item) }}" class="btn btn-light btn-sm">Edit</a>
                                        <form action="{{ route('operator.perbaikan.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Hapus jadwal maintenance ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">
                                    <div style="font-size:32px">🛠️</div>
                                    <h4>Belum Ada Maintenance</h4>
                                    <p style="margin-bottom:14px">Belum terdapat jadwal maintenance untuk charger Anda.</p>
                                    <a href="{{ route('operator.perbaikan.create') }}" class="btn btn-sm">+ Buat Jadwal Maintenance</a>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noResult" style="display:none"><td colspan="5" class="empty">Tidak ada jadwal yang cocok.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        // Filter status & pencarian pada data yang tampil di halaman (tidak mengubah data di server)
        (function () {
            const rows = document.querySelectorAll('.maint-row');
            const chips = document.querySelectorAll('#chips .chip');
            const input = document.getElementById('searchMaintenance');
            const noResult = document.getElementById('noResult');
            const count = document.getElementById('rowCount');
            const total = rows.length;
            let filter = 'semua';

            function apply() {
                const q = input.value.trim().toLowerCase();
                let shown = 0;
                rows.forEach(function (row) {
                    const ok = (filter === 'semua' || row.dataset.status === filter) && (!q || row.dataset.search.includes(q));
                    row.style.display = ok ? '' : 'none';
                    if (ok) shown++;
                });
                noResult.style.display = (total > 0 && shown === 0) ? '' : 'none';
                count.textContent = (shown === total ? total : shown + ' dari ' + total) + ' jadwal';
            }

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    filter = chip.dataset.filter;
                    chips.forEach(function (c) { c.classList.toggle('active', c === chip); });
                    apply();
                });
            });
            input.addEventListener('input', apply);
        })();
    </script>
</body>
</html>