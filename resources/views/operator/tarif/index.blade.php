<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tarif - EVChargeHub</title>
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
    .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .actions form { margin: 0; display: inline; }

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
    td .actions { flex-wrap: nowrap; gap: 6px; }

    /* ===== ALERT ===== */
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }

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
    .dot.berlaku { background: #22c55e; }
    .dot.riwayat { background: #94a3b8; }

    .search { display: flex; align-items: center; gap: 12px; }
    .search input {
        width: 250px; max-width: 100%; padding: 9px 13px; border: 1px solid var(--line); border-radius: 10px;
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
    .price { font-size: 13px; font-weight: 800; color: var(--text); }
    .hint { color: #98a2b3; font-size: 11px; display: block; margin-top: 2px; }
    .empty { text-align: center; color: #98a2b3; padding: 30px !important; font-size: 13px; }
    tr.row-riwayat td { color: #98a2b3; }
    tr.row-riwayat td strong, tr.row-riwayat .price { color: #78869b; }

    /* ===== BADGE ===== */
    .badge { display: inline-block; padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #f1f5f9; color: #64748b; }
    .badge-berlaku { background: #dcfce7; color: #166534; }
    .badge-riwayat { background: #f1f5f9; color: #64748b; }

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

    @php
        // Tentukan tarif yang sedang berlaku per charger (tarif terbaru yang tanggalnya sudah tiba).
        $tarifBerlakuIds = $tarifs
            ->filter(fn ($t) => \Carbon\Carbon::parse($t->berlaku_mulai)->lte(now()))
            ->groupBy(fn ($t) => $t->charger->id_charger ?? ('tarif-' . $t->id))
            ->map(fn ($g) => $g->sortByDesc('berlaku_mulai')->first()->id)
            ->values()
            ->all();

        $statusTarif = function ($t) use ($tarifBerlakuIds) {
            if (\Carbon\Carbon::parse($t->berlaku_mulai)->gt(now())) return 'terjadwal';
            return in_array($t->id, $tarifBerlakuIds) ? 'berlaku' : 'riwayat';
        };
        $labelTarif = ['berlaku' => 'Berlaku'];
        $hitung = ['berlaku' => 0];
        foreach ($tarifs as $t) { $hitung[$statusTarif($t)]++; }
    @endphp

    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ route('operator.tarif.index') }}" class="active">💰 Tarif</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Daftar Tarif</h2>
                <p>Kelola tarif pengisian untuk setiap charger.</p>
            </div>
            <div class="actions">
                <a class="btn btn-light" href="{{ url('/operator/dashboard') }}">← Dashboard</a>
                <a class="btn" href="{{ route('operator.tarif.create') }}">+ Tambah Tarif</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <section class="dashboard-panel">

            {{-- Filter status tarif + pencarian cepat (di halaman) --}}
            <div class="toolbar">
                <div class="chips" id="chips">
                    @foreach ($labelTarif as $key => $label)
                        <button type="button" class="chip" data-filter="{{ $key }}">
                            <span class="dot {{ $key }}"></span>{{ $label }} <span class="n">{{ $hitung[$key] }}</span>
                        </button>
                    @endforeach
                </div>
                <div class="search">
                    <span class="count" id="rowCount">{{ $tarifs->count() }} tarif</span>
                    <input type="text" id="searchTarif" placeholder="🔍 Cari stasiun atau kode charger...">
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr><th>Charger</th><th>Harga / kWh</th><th>Berlaku Mulai</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($tarifs as $t)
                            @php $st = $statusTarif($t); @endphp
                            <tr class="tarif-row row-{{ $st }}" data-status="{{ $st }}"
                                data-search="{{ strtolower(($t->charger->kd_charger ?? '') . ' ' . ($t->charger->station->nama_st ?? '') . ' ' . $t->harga_per_kWh) }}">
                                <td>
                                    <strong>{{ $t->charger->kd_charger ?? '-' }}</strong>
                                    <span class="hint">{{ $t->charger->station->nama_st ?? '-' }} · ID #{{ $t->id }}</span>
                                </td>
                                <td><span class="price">Rp {{ number_format($t->harga_per_kWh, 0, ',', '.') }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($t->berlaku_mulai)->format('d/m/Y') }}</td>
                                <td><span class="badge badge-{{ $st }}">{{ $labelTarif[$st] }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a class="btn btn-light btn-sm" href="{{ route('operator.tarif.edit', $t->id) }}">Edit</a>
                                        <form method="POST" action="{{ route('operator.tarif.destroy', $t->id) }}"
                                              class="form-hapus"
                                              data-konfirmasi="Hapus tarif Rp {{ number_format($t->harga_per_kWh, 0, ',', '.') }} untuk charger {{ $t->charger->kd_charger ?? '-' }}?">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty">Belum ada tarif.</td></tr>
                        @endforelse
                        <tr id="noResult" style="display:none"><td colspan="5" class="empty">Tidak ada tarif yang cocok.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        // Filter status & pencarian pada data yang tampil di halaman (tidak mengubah data di server)
        (function () {
            const rows = document.querySelectorAll('.tarif-row');
            const chips = document.querySelectorAll('#chips .chip');
            const input = document.getElementById('searchTarif');
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
                count.textContent = (shown === total ? total : shown + ' dari ' + total) + ' tarif';
            }

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    filter = chip.dataset.filter;
                    chips.forEach(function (c) { c.classList.toggle('active', c === chip); });
                    apply();
                });
            });
            input.addEventListener('input', apply);

            // Konfirmasi sebelum menghapus tarif
            document.querySelectorAll('.form-hapus').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (!confirm(form.dataset.konfirmasi)) e.preventDefault();
                });
            });
        })();
    </script>
</body>
</html>