<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Charger - EVChargeHub</title>
    <style>
    :root {
        --green: #3d9e71;
        --green-dark: #2f7d59;
        --green-soft: #e0f1e8;
        --text: #172033;
        --muted: #8390a5;
        --line: #e7ecf3;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f5f7fb;
        color: var(--text);
        display: flex;
        min-height: 100vh;
        font-size: 14px;
    }
    a { color: var(--green); text-decoration: none; }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 240px;
        background: linear-gradient(180deg, #3d9e71, #2a7352);
        color: #fff;
        padding: 24px 16px;
        flex-shrink: 0;
    }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a {
        display: block;
        color: #e6f5ed;
        padding: 12px 14px;
        border-radius: 10px;
        margin-bottom: 10px;
        font-size: 14px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transition: background 0.2s, transform 0.2s;
    }
    .sidebar nav a:hover { background: rgba(255, 255, 255, 0.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active {
        background: rgba(255, 255, 255, 0.28);
        border-color: rgba(255, 255, 255, 0.5);
        color: #fff;
        font-weight: 700;
    }

    /* ===== MAIN & TOPBAR ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar {
        display: flex; justify-content: space-between; align-items: center;
        gap: 12px; flex-wrap: wrap; margin-bottom: 22px;
    }
    .topbar h2 { font-size: 22px; font-weight: 800; }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }

    .section-title { font-size: 16px; font-weight: 800; margin: 0; }
    .section-subtitle { color: var(--muted); font-size: 12px; margin-top: 5px; }

    /* ===== BUTTON ===== */
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

    /* ===== ALERT ===== */
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }

    /* ===== PANEL ===== */
    .dashboard-panel {
        background: white; border: 1px solid var(--line); border-radius: 15px;
        overflow: hidden; margin-bottom: 22px;
    }

    /* ===== TOOLBAR (filter + pencarian) ===== */
    .toolbar {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        flex-wrap: wrap; padding: 16px 20px; border-bottom: 1px solid #edf0f5;
    }
    .chips { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip {
        display: inline-flex; align-items: center; gap: 7px; padding: 7px 12px; border-radius: 999px;
        border: 1px solid var(--line); background: #fff; color: #475569;
        font-size: 12px; font-weight: 700; text-transform: capitalize; transition: .2s;
    }
    .chip:hover { border-color: #a6d8bf; color: var(--text); }
    .chip.active { border-color: var(--green); background: var(--green-soft); color: var(--green-dark); box-shadow: 0 0 0 3px #3d9e7118; }
    .chip .n {
        min-width: 22px; padding: 1px 7px; border-radius: 10px; background: #f1f5f9;
        color: #64748b; font-size: 11px; text-align: center;
    }
    .chip.active .n { background: #fff; color: var(--green-dark); }
    .dot { width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; }
    .dot.tersedia { background: #22c55e; }
    .dot.digunakan { background: #3b82f6; }
    .dot.perbaikan { background: #f59e0b; }
    .dot.error { background: #dc2626; }

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
    th {
        padding: 13px 18px; text-align: left; background: #f8fafc; color: #78869b;
        font-weight: 700; border-bottom: 1px solid #edf0f5;
    }
    td { padding: 14px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    td strong { color: var(--text); }
    .hint { color: #98a2b3; font-size: 11px; display: block; margin-top: 2px; }
    .empty { text-align: center; color: #98a2b3; padding: 30px !important; font-size: 13px; }
    .power { font-weight: 700; color: var(--text); }

    /* ===== BADGE ===== */
    .badge {
        display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: 700;
        background: #f1f5f9; color: #64748b; text-transform: capitalize;
    }
    .badge-tersedia { background: #dcfce7; color: #166534; }
    .badge-perbaikan { background: #ffedd5; color: #9a3412; }
    .badge-error { background: #fee2e2; color: #b91c1c; }
    .badge-digunakan { background: #dbeafe; color: #1d4ed8; }

    .actions { display: flex; gap: 6px; align-items: center; flex-wrap: nowrap; }
    .actions form { margin: 0; }

    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
    @media (max-width: 640px) {
        .search, .search input { width: 100%; }
    }
</style>
</head>
<body>
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}" class="active">🔌 Charger</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Daftar Charger</h2>
                <p>Kelola unit charger yang terdaftar di stasiun Anda.</p>
            </div>
            <a href="{{ route('operator.charger.create') }}" class="btn">+ Tambah Charger</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <section class="dashboard-panel">

            {{-- Filter status (server-side) + pencarian cepat (di halaman) --}}
            <div class="toolbar">
                <div class="chips">
                    <a class="chip {{ !$filter ? 'active' : '' }}" href="{{ route('operator.charger.index') }}">
                        Semua <span class="n">{{ $counts['semua'] }}</span>
                    </a>
                    @foreach (['tersedia', 'digunakan', 'perbaikan', 'error'] as $s)
                        <a class="chip {{ $filter === $s ? 'active' : '' }}" href="{{ route('operator.charger.index', ['status' => $s]) }}">
                            <span class="dot {{ $s }}"></span>{{ $s }} <span class="n">{{ $counts[$s] }}</span>
                        </a>
                    @endforeach
                </div>
                <div class="search">
                    <span class="count" id="rowCount">{{ $chargers->count() }} unit</span>
                    <input type="text" id="searchCharger" placeholder="🔍 Cari kode, stasiun, konektor...">
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Charger</th>
                            <th>Stasiun</th>
                            <th>Konektor &amp; Daya</th>
                            <th>Tarif Berlaku</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="chargerBody">
                        @forelse ($chargers as $c)
                            @php
                                $tarifAktif = $c->tarifs
                                    ->sortByDesc('berlaku_mulai')
                                    ->first(fn ($t) => \Carbon\Carbon::parse($t->berlaku_mulai)->lte(now()));
                                $daya = rtrim(rtrim(number_format($c->daya_maks, 1, ',', '.'), '0'), ',');
                            @endphp
                            <tr class="charger-row"
                                data-search="{{ strtolower($c->kd_charger . ' ' . ($c->station->nama_st ?? '') . ' ' . ($c->konektor->nm_konektor ?? '') . ' ' . ($c->konektor->jenis_charging ?? '') . ' ' . $c->status) }}">
                                <td><strong>{{ $c->kd_charger }}</strong></td>
                                <td>{{ $c->station->nama_st ?? '-' }}</td>
                                <td>
                                    {{ $c->konektor->nm_konektor ?? '-' }}
                                    <span class="hint">
                                        @if ($c->konektor?->jenis_charging){{ $c->konektor->jenis_charging }} · @endif<span class="power">{{ $daya }} kW</span>
                                    </span>
                                </td>
                                <td>
                                    @if ($tarifAktif)
                                        <strong>Rp {{ number_format($tarifAktif->harga_per_kWh, 0, ',', '.') }}</strong><span class="hint">per kWh</span>
                                    @else
                                        <span class="hint">Belum ada tarif</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $c->status }}">{{ $c->status }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('operator.charger.show', $c->id_charger) }}" class="btn btn-light btn-sm">Detail</a>
                                        <a href="{{ route('operator.charger.edit', $c->id_charger) }}" class="btn btn-light btn-sm">Edit</a>
                                        @if ($c->status !== 'digunakan')
                                            <form action="{{ route('operator.charger.destroy', $c->id_charger) }}" method="POST"
                                                  onsubmit="return confirm(@json('Hapus charger ' . $c->kd_charger . '?'))">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty">Belum ada charger.</td></tr>
                        @endforelse
                        <tr id="noResult" style="display:none"><td colspan="6" class="empty">Tidak ada charger yang cocok dengan pencarian.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        // Pencarian cepat pada data yang sedang ditampilkan (tidak mengubah filter server)
        (function () {
            const input = document.getElementById('searchCharger');
            const rows = document.querySelectorAll('.charger-row');
            const noResult = document.getElementById('noResult');
            const count = document.getElementById('rowCount');
            const total = rows.length;

            input.addEventListener('input', function () {
                const q = input.value.trim().toLowerCase();
                let shown = 0;
                rows.forEach(function (row) {
                    const match = !q || row.dataset.search.includes(q);
                    row.style.display = match ? '' : 'none';
                    if (match) shown++;
                });
                noResult.style.display = (total > 0 && shown === 0) ? '' : 'none';
                count.textContent = (q ? shown + ' dari ' + total : total) + ' unit';
            });
        })();
    </script>
</body>
</html>