<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charger {{ $charger->kd_charger }} - EVChargeHub</title>
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
        text-decoration: none;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .topbar h2 { font-size: 22px; font-weight: 800; color: var(--text); }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .actions form { margin: 0; }

    .section-title { font-size: 16px; font-weight: 800; margin: 0; }
    .section-subtitle { color: var(--muted); font-size: 12px; margin-top: 5px; }

    /* ===== BUTTON ===== */
    .btn {
        display: inline-block;
        padding: 9px 16px;
        border-radius: 9px;
        border: 1px solid transparent;
        font-size: 12px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        background: var(--green);
        color: #fff;
        transition: .2s;
    }
    .btn:hover { background: var(--green-dark); transform: translateY(-2px); color: #fff; }
    .btn-light { background: #fff; color: var(--text); border-color: var(--line); }
    .btn-light:hover { background: #f1f5f9; color: var(--text); }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-sm { padding: 6px 11px; font-size: 11px; }

    /* ===== ALERT ===== */
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }
    .alert ul { margin: 6px 0 0 18px; }

    /* ===== PANEL ===== */
    .dashboard-panel {
        background: white;
        border: 1px solid var(--line);
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 22px;
    }
    .panel-header {
        padding: 20px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #edf0f5;
        flex-wrap: wrap;
    }
    .panel-header.tinted { background: linear-gradient(90deg, #eef8f2, #ffffff); }
    .panel-body { padding: 20px 22px; }
    .panel-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    .panel-count {
        padding: 6px 10px;
        border-radius: 8px;
        background: var(--green-soft);
        color: var(--green-dark);
        font-size: 11px;
        font-weight: 700;
    }

    /* ===== TABLE ===== */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap; }
    th {
        padding: 14px 18px;
        text-align: left;
        background: #f8fafc;
        color: #78869b;
        font-weight: 700;
        border-bottom: 1px solid #edf0f5;
    }
    td { padding: 15px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    td strong { color: var(--text); }
    .hint { color: #98a2b3; font-size: 11px; }
    .empty { text-align: center; color: #98a2b3; padding: 28px !important; font-size: 13px; }

    /* ===== BADGE ===== */
    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
        text-transform: capitalize;
    }
    .badge.green, .badge-tersedia { background: #dcfce7; color: #166534; }
    .badge.orange, .badge-perbaikan { background: #ffedd5; color: #9a3412; }
    .badge.red, .badge-error { background: #fee2e2; color: #b91c1c; }
    .badge.blue, .badge-digunakan { background: #dbeafe; color: #1d4ed8; }

    /* ===== FILTER CARD (index charger) ===== */
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }
    .filter-card {
        display: block;
        background: white;
        border: 1px solid var(--line);
        border-radius: 15px;
        padding: 18px;
        box-shadow: 0 4px 16px #16274805;
        color: var(--text);
        transition: .2s;
    }
    .filter-card:hover { transform: translateY(-3px); border-color: #a6d8bf; color: var(--text); }
    .filter-card.active { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .filter-num { font-size: 28px; font-weight: 800; letter-spacing: -1px; }
    .filter-label { margin-top: 6px; font-size: 11px; color: #77849a; font-weight: 600; }

    /* ===== FORM ===== */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-grid .form-group { margin-bottom: 0; }
    .form-grid { margin-bottom: 20px; }
    .form-group label { font-weight: 700; font-size: 12px; color: #475569; }
    .form-control {
        padding: 11px 13px;
        border: 1px solid var(--line);
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        background: #fff;
        color: var(--text);
        outline: none;
        transition: .2s;
        width: 100%;
    }
    .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .form-control.is-invalid { border-color: #dc2626; }
    .field-error { color: #b91c1c; font-size: 11px; }
    .form-actions { display: flex; gap: 10px; margin-top: 8px; }

    /* ===== DETAIL LIST (show charger) ===== */
    .detail { display: grid; grid-template-columns: 200px 1fr; row-gap: 14px; }
    .detail dt { color: var(--muted); font-size: 12px; }
    .detail dd { margin: 0; font-weight: 700; color: var(--text); }
    .inline-status { display: flex; gap: 8px; align-items: center; }
    .inline-status select { width: auto; }

    .dashboard-footer { text-align: center; color: #98a2b3; font-size: 11px; padding: 10px; }

    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .detail { grid-template-columns: 1fr; row-gap: 4px; }
        .detail dd { margin-bottom: 10px; }
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
            <a href="{{ url('/operator/tarif') }}">💰 Tarif</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    @php
        $tarifs = $charger->tarifs->sortByDesc('berlaku_mulai');
        $tarifAktif = $tarifs->first(fn ($t) => \Carbon\Carbon::parse($t->berlaku_mulai)->lte(now()));
    @endphp

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Charger {{ $charger->kd_charger }}
                    <span class="badge badge-{{ $charger->status }}" style="vertical-align:middle">{{ $charger->status }}</span>
                </h2>
                <p>Detail unit charger, status, dan riwayat tarif.</p>
            </div>
            <div class="actions">
                <a href="{{ route('operator.charger.index') }}" class="btn btn-light">← Kembali</a>
                <a href="{{ route('operator.charger.edit', $charger->id_charger) }}" class="btn">Edit</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <section class="dashboard-panel">
            <div class="panel-header">
                <h3 class="section-title">Informasi Charger</h3>
            </div>
            <div class="panel-body">
                <dl class="detail">
                    <dt>Kode Charger</dt><dd>{{ $charger->kd_charger }}</dd>
                    <dt>Stasiun</dt><dd>{{ $charger->station->nama_st ?? '-' }}</dd>
                    <dt>Alamat Stasiun</dt><dd>{{ $charger->station->alamat ?? '-' }}</dd>
                    <dt>Tipe Konektor</dt>
                    <dd>{{ $charger->konektor->nm_konektor ?? '-' }}
                        @if ($charger->konektor?->jenis_charging) ({{ $charger->konektor->jenis_charging }}) @endif
                    </dd>
                    <dt>Daya Maksimum</dt><dd>{{ rtrim(rtrim(number_format($charger->daya_maks, 1, ',', '.'), '0'), ',') }} kW</dd>
                    <dt>Tarif Berlaku</dt>
                    <dd>
                        @if ($tarifAktif)
                            Rp {{ number_format($tarifAktif->harga_per_kWh, 0, ',', '.') }}/kWh
                        @else
                            <span class="hint">Belum ada tarif</span>
                        @endif
                    </dd>
                    <dt>Riwayat Perbaikan</dt><dd>{{ $charger->perbaikan()->count() }} catatan</dd>
                </dl>
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="panel-header">
                <h3 class="section-title">Ubah Status</h3>
            </div>
            <div class="panel-body">
                @if ($charger->status === 'digunakan')
                    <p class="hint">Charger sedang digunakan, status tidak dapat diubah.</p>
                @else
                    <form action="{{ route('operator.charger.updateStatus', $charger->id_charger) }}" method="POST" class="inline-status">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-control">
                            @foreach (['tersedia', 'perbaikan', 'error'] as $s)
                                <option value="{{ $s }}" {{ $charger->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm">Simpan Status</button>
                    </form>
                @endif
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Riwayat Tarif</h3>
                    <div class="section-subtitle">Kelola tarif di menu <a href="{{ url('/operator/tarif') }}">Tarif</a>.</div>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Berlaku Mulai</th><th>Harga per kWh</th></tr></thead>
                    <tbody>
                        @forelse ($tarifs as $t)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($t->berlaku_mulai)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($t->harga_per_kWh, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="empty">Belum ada tarif untuk charger ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>