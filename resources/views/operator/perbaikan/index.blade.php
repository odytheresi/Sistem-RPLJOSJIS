<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Charger - EVChargeHub</title>
    <style>
    :root { --green: #3d9e71; --green-dark: #2f7d59; --text: #172033; --muted: #8390a5; --line: #e7ecf3; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; color: var(--text); display: flex; min-height: 100vh; font-size: 14px; }
    a { color: var(--green); text-decoration: none; }

    /* ===== SIDEBAR ===== */
    .sidebar { width: 240px; background: linear-gradient(180deg, #3d9e71, #2a7352); color: #fff; padding: 24px 16px; flex-shrink: 0; }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a {
        display: block; color: #e6f5ed; text-decoration: none; padding: 12px 14px; border-radius: 10px;
        margin-bottom: 10px; font-size: 14px; background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18); transition: background 0.2s, transform 0.2s;
    }
    .sidebar nav a:hover { background: rgba(255, 255, 255, 0.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active { background: rgba(255, 255, 255, 0.28); border-color: rgba(255, 255, 255, 0.5); color: #fff; font-weight: 700; }

    /* ===== MAIN & TOPBAR ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
    .topbar h2 { font-size: 22px; font-weight: 800; color: var(--text); }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .actions form { margin: 0; display: inline; }
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
    .btn-warning { background: #f59e0b; color: #fff; }
    .btn-warning:hover { background: #d97706; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-sm { padding: 6px 11px; font-size: 11px; }

    /* ===== ALERT & NOTE ===== */
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }
    .alert ul { margin: 6px 0 0 18px; }
    .note { display: flex; gap: 12px; padding: 16px; background: #eef8f2; border: 1px solid #cfe8da; border-radius: 12px; color: #2f7d59; font-size: 12px; margin-bottom: 18px; line-height: 1.6; }

    /* ===== STAT CARD ===== */
    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 17px; margin-bottom: 26px; }
    .stat-card { background: white; border: 1px solid #e8edf4; border-radius: 15px; padding: 21px; box-shadow: 0 4px 16px #16274805; min-width: 0; }
    .stat-icon { width: 43px; height: 43px; display: grid; place-items: center; border-radius: 12px; font-size: 20px; }
    .bg-green-soft { background: #e0f1e8; }
    .bg-green { background: #dcfce7; }
    .bg-orange { background: #ffedd5; }
    .bg-blue { background: #dbeafe; }
    .bg-gray { background: #f1f5f9; }
    .stat-label { font-size: 12px; color: #77849a; font-weight: 600; margin-top: 17px; }
    .stat-value { font-size: 30px; font-weight: 800; letter-spacing: -1px; margin-top: 5px; color: var(--text); }
    .stat-note { color: #98a2b3; font-size: 11px; margin-top: 5px; }

    /* ===== PANEL & TABLE ===== */
    .dashboard-panel { background: white; border: 1px solid var(--line); border-radius: 15px; overflow: hidden; margin-bottom: 22px; }
    .panel-header { padding: 20px 22px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border-bottom: 1px solid #edf0f5; flex-wrap: wrap; }
    .panel-body { padding: 22px; }
    .panel-count { padding: 6px 10px; border-radius: 8px; background: #e0f1e8; color: var(--green-dark); font-size: 11px; font-weight: 700; }
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap; }
    th { padding: 14px 18px; text-align: left; background: #f8fafc; color: #78869b; font-weight: 700; border-bottom: 1px solid #edf0f5; }
    td { padding: 15px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    td strong { color: var(--text); }
    .hint { color: #98a2b3; font-size: 11px; }
    .empty { text-align: center; color: #98a2b3; padding: 40px 20px !important; font-size: 13px; }
    .empty h4 { color: var(--text); font-size: 14px; margin: 8px 0 4px; }
    .wrap-text { white-space: normal; min-width: 220px; }

    /* ===== BADGE ===== */
    .badge { display: inline-block; padding: 5px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #f1f5f9; color: #64748b; text-transform: capitalize; }
    .badge-lg { padding: 7px 14px; font-size: 11px; }
    .badge-menunggu { background: #ffedd5; color: #9a3412; }
    .badge-diproses, .badge-proses { background: #dbeafe; color: #1d4ed8; }
    .badge-selesai { background: #dcfce7; color: #166534; }
    .badge-ditolak, .badge-dibatalkan { background: #fee2e2; color: #b91c1c; }
    .badge-dijadwalkan { background: #e2e8f0; color: #475569; }

    /* ===== DETAIL ===== */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .info-item { padding: 16px; background: #f8faff; border: 1px solid #edf0f6; border-radius: 12px; }
    .info-item.full { grid-column: 1 / -1; }
    .info-label { font-size: 11px; color: #8290a5; font-weight: 600; margin-bottom: 6px; }
    .info-value { font-size: 13px; font-weight: 700; color: var(--text); }
    .content-box { padding: 20px; background: #f7f9fd; border: 1px solid #e7edf7; border-radius: 12px; line-height: 1.8; white-space: pre-line; color: #344563; font-size: 13px; }
    .summary { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; }
    .summary h3 { font-size: 20px; font-weight: 800; margin: 12px 0 4px; }
    .inline-status { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .inline-status select { width: auto; min-width: 180px; }

    /* ===== FORM ===== */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .form-group label { font-weight: 700; font-size: 12px; color: #475569; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
    .form-row .form-group { margin-bottom: 0; }
    .form-control {
        padding: 11px 13px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px;
        font-family: inherit; background: #fff; color: var(--text); outline: none; transition: .2s; width: 100%;
    }
    textarea.form-control { min-height: 110px; resize: vertical; }
    .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .form-control.is-invalid { border-color: #dc2626; }
    .form-text { color: #98a2b3; font-size: 11px; }
    .field-error { color: #b91c1c; font-size: 11px; }
    .form-section { font-weight: 800; font-size: 14px; margin: 4px 0 14px; color: #263c65; }
    .divider { border: 0; border-top: 1px solid #edf0f6; margin: 22px 0; }
    .form-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 8px; padding-top: 20px; border-top: 1px solid #edf0f6; }
    .required { color: #dc2626; }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
    @media (max-width: 640px) {
        .stats-grid, .info-grid, .form-row { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn { width: 100%; text-align: center; }
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
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ route('operator.tarif.index') }}">💰 Tarif</a>
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

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon bg-green-soft">🛠️</div>
                <div class="stat-label">Total Maintenance</div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-note">Seluruh jadwal</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-gray">📅</div>
                <div class="stat-label">Dijadwalkan</div>
                <div class="stat-value">{{ $dijadwalkan }}</div>
                <div class="stat-note">Menunggu pelaksanaan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-blue">🔄</div>
                <div class="stat-label">Dalam Proses</div>
                <div class="stat-value">{{ $proses }}</div>
                <div class="stat-note">Sedang diperbaiki</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-green">✅</div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value">{{ $selesai }}</div>
                <div class="stat-note">Maintenance selesai</div>
            </div>
        </div>

        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Daftar Maintenance</h3>
                    <div class="section-subtitle">Informasi jadwal dan status perbaikan charger.</div>
                </div>
                <span class="panel-count">{{ $total }} jadwal</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Charger</th>
                            <th>Lokasi Stasiun</th>
                            <th>Jenis Maintenance</th>
                            <th>Tanggal Jadwal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($perbaikan as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->charger->kd_charger ?? '-' }}</strong>
                                    <div class="hint">{{ $item->charger->konektor->nm_konektor ?? '-' }}</div>
                                </td>
                                <td>{{ $item->charger->station->nama_st ?? '-' }}</td>
                                <td>{{ $item->jenis_maintenance }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_jadwal)->format('d M Y') }}</td>
                                <td><span class="badge badge-{{ $item->status }}">{{ $item->status }}</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('operator.perbaikan.show', $item) }}" class="btn btn-light btn-sm">Detail</a>
                                        <a href="{{ route('operator.perbaikan.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
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
                                <td colspan="6" class="empty">
                                    <div style="font-size:32px">🛠️</div>
                                    <h4>Belum Ada Maintenance</h4>
                                    <p style="margin-bottom:14px">Belum terdapat jadwal maintenance untuk charger Anda.</p>
                                    <a href="{{ route('operator.perbaikan.create') }}" class="btn btn-sm">+ Buat Jadwal Maintenance</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>