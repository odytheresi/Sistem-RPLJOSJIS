<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lokasi Stasiun - EVChargeHub</title>
<!-- Leaflet CSS untuk Peta -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

    .dashboard-footer { text-align: center; color: #98a2b3; font-size: 11px; padding: 10px; }

    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
</style>
<style>
    .search-box { margin-bottom: 24px; }
    .search-box input {
        width: 100%;
        padding: 14px 18px;
        font-size: 13px;
        font-family: inherit;
        color: var(--text);
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 4px 16px #16274805;
        outline: none;
        transition: .2s;
    }
    .search-box input::placeholder { color: #98a2b3; }
    .search-box input:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .station-list { display: flex; flex-direction: column; }
    .table-title {
        font-size: 11px; font-weight: 800; color: #78869b;
        text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
    }
    .empty-text { color: #98a2b3; font-size: 12px; font-style: italic; }
    .empty-box {
        background: white; border: 1px solid var(--line); border-radius: 15px;
        padding: 48px 20px; text-align: center; color: #98a2b3; font-size: 13px;
    }

    /* ===== PANEL NAVIGASI (ala Google Maps) ===== */
    .nav-layout { display: grid; grid-template-columns: 350px 1fr; min-height: 560px; }
    .nav-side { border-right: 1px solid #edf0f5; max-height: 620px; overflow-y: auto; padding: 16px; }
    .map-wrap { position: relative; min-height: 560px; }
    #map { position: absolute; inset: 0; z-index: 0; }

    .nav-status {
        font-size: 12px; padding: 10px 12px; border-radius: 10px; margin-bottom: 14px;
        background: #f1f5f9; color: #475569;
    }
    .nav-status.ok { background: #dcfce7; color: #166534; }
    .nav-status.err { background: #fee2e2; color: #b91c1c; }

    .st-item {
        border: 1px solid var(--line); border-radius: 12px; padding: 12px 14px;
        margin-bottom: 10px; cursor: pointer; transition: .2s; background: #fff;
    }
    .st-item:hover { border-color: #a6d8bf; transform: translateY(-2px); }
    .st-item.selected { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; background: #f6fcf9; }
    .st-item .st-name { font-weight: 800; font-size: 13px; }
    .st-item .st-addr { color: var(--muted); font-size: 11px; margin: 3px 0 8px; }
    .st-item .st-meta { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }

    /* Stasiun yang sedang tidak bisa digunakan */
    .st-item.down { background: #fafafa; border-style: dashed; }
    .st-item.down .st-name { color: #64748b; }
    .st-item.down:hover { border-color: #fca5a5; }
    .st-warn { margin-top: 8px; font-size: 11px; font-weight: 700; color: #b91c1c; }

    .route-card {
        display: none; border: 1px solid var(--green); border-radius: 14px;
        padding: 14px; margin-bottom: 14px; background: #f6fcf9;
    }
    .route-card.show { display: block; }
    .route-dest { font-size: 12px; color: var(--muted); margin-bottom: 4px; }
    .route-eta { font-size: 24px; font-weight: 800; color: var(--green-dark); letter-spacing: -.5px; }
    .route-sub { font-size: 12px; color: #475569; margin: 4px 0 12px; }
    .route-btns { display: flex; gap: 8px; }
    .route-btns .btn { flex: 1; text-align: center; }

    .steps { list-style: none; margin-top: 4px; }
    .steps li {
        display: flex; gap: 10px; padding: 9px 2px; border-bottom: 1px solid #f0f2f6;
        font-size: 12px; color: #475569; align-items: flex-start;
    }
    .steps li:last-child { border-bottom: 0; }
    .steps .ic { width: 22px; text-align: center; font-size: 15px; color: var(--green-dark); flex-shrink: 0; }
    .steps .dist { margin-left: auto; color: #98a2b3; white-space: nowrap; font-size: 11px; }

    .nav-banner {
        position: absolute; top: 12px; left: 12px; right: 12px; z-index: 500;
        background: #1b5e43; color: #fff; border-radius: 14px; padding: 12px 16px;
        box-shadow: 0 6px 20px rgba(0,0,0,.25); display: none; align-items: center; gap: 14px;
    }
    .nav-banner.show { display: flex; }
    .nav-banner .arrow { font-size: 30px; line-height: 1; }
    .nav-banner .b-main { font-weight: 800; font-size: 15px; }
    .nav-banner .b-sub { font-size: 12px; opacity: .85; margin-top: 2px; }

    .map-fab {
        position: absolute; right: 12px; bottom: 28px; z-index: 500;
        background: #fff; border: 1px solid var(--line); border-radius: 50%;
        width: 46px; height: 46px; font-size: 20px; cursor: pointer;
        box-shadow: 0 4px 14px rgba(0,0,0,.2);
    }
    .map-fab:hover { background: #f1f5f9; }

    .ev-pin {
        background: var(--green); color: #fff; width: 30px; height: 30px; border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg); display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,.4);
    }
    .ev-pin span { transform: rotate(45deg); font-size: 14px; }
    .ev-pin.sel { background: #dc2626; }
    .ev-pin.down { background: #94a3b8; }
    .user-dot {
        background: #1a73e8; width: 18px; height: 18px; border-radius: 50%;
        border: 3px solid #fff; box-shadow: 0 0 0 4px rgba(26,115,232,.3), 0 2px 6px rgba(0,0,0,.5);
    }

    /* ===== MODAL "TIDAK BISA DIGUNAKAN" ===== */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: all .2s ease; z-index: 2000; padding: 16px;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-box {
        background: #fff; width: 100%; max-width: 480px; border-radius: 15px; padding: 22px;
        border: 1px solid var(--line); box-shadow: 0 10px 25px rgba(0,0,0,.1);
        transform: translateY(10px); transition: transform .2s ease; max-height: 90vh; overflow-y: auto;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-header {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;
        margin-bottom: 14px; border-bottom: 1px solid #edf0f5; padding-bottom: 12px;
    }
    .modal-header h3 { font-size: 16px; font-weight: 800; color: #b91c1c; line-height: 1.4; }
    .modal-close {
        background: #f1f5f9; border: 0; width: 28px; height: 28px; border-radius: 50%;
        cursor: pointer; color: #64748b; font-size: 16px; flex-shrink: 0;
    }
    .ua-intro { font-size: 13px; color: #475569; margin-bottom: 12px; line-height: 1.6; }
    .ua-list { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .ua-list li { border: 1px solid #f0f2f6; background: #f8fafc; border-radius: 12px; padding: 12px 14px; }
    .ua-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .ua-head strong { font-size: 13px; }
    .ua-detail { margin-top: 8px; font-size: 12px; color: #475569; line-height: 1.6; }
    .ua-detail b { color: var(--text); }
    .modal-footer { margin-top: 16px; display: flex; justify-content: flex-end; }

    @media (max-width: 900px) {
        .nav-layout { grid-template-columns: 1fr; }
        .map-wrap { order: 1; min-height: 420px; }
        .nav-side { order: 2; border-right: 0; border-top: 1px solid #edf0f5; max-height: none; }
    }
</style>
</head>
<body>

    @php
        // Data stasiun untuk JavaScript (hanya yang punya koordinat)
        $stationsData = isset($chargingStations)
            ? $chargingStations->filter(fn($s) => $s->latitude && $s->longitude)->map(function ($s) {

                // Charger yang tidak tersedia + alasan (status & keterangan maintenance yang masih berjalan)
                $masalah = $s->chargers->filter(fn($c) => $c->status !== 'tersedia')->map(function ($c) {
                    $list  = $c->perbaikan;
                    $list  = ($list instanceof \Illuminate\Support\Collection) ? $list : collect($list ? [$list] : []);
                    $aktif = $list->whereIn('status', ['dijadwalkan', 'proses'])->sortByDesc('tgl_jadwal')->first();

                    return [
                        'kode'       => $c->kd_charger,
                        'status'     => $c->status,
                        'jenis'      => $aktif->jenis_maintenance ?? null,
                        'keterangan' => $aktif->keterangan ?? null,
                        'status_mt'  => $aktif->status ?? null,
                        'tgl'        => ($aktif && $aktif->tgl_jadwal) ? \Carbon\Carbon::parse($aktif->tgl_jadwal)->format('d M Y') : null,
                    ];
                })->values();

                return [
                    'id'       => (string) $s->getKey(),
                    'nama'     => $s->nama_st,
                    'alamat'   => $s->alamat,
                    'lat'      => (float) $s->latitude,
                    'lng'      => (float) $s->longitude,
                    'status'   => $s->status ?? 'Aktif',
                    'total'    => $s->chargers->count(),
                    'tersedia' => $s->chargers->where('status', 'tersedia')->count(),
                    'masalah'  => $masalah,
                ];
            })->values()
            : collect();
    @endphp

    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}" class="active">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    <main class="main">

        <div class="topbar">
            <div>
                <h2>Lokasi Stasiun</h2>
                <p>Kelola dan pantau seluruh lokasi stasiun beserta perangkat charger secara menyeluruh.</p>
            </div>
            <a href="{{ route('operator.dashboard') }}" class="btn">← Kembali ke Dashboard</a>
        </div>

        <!-- ===== PANEL NAVIGASI ===== -->
        <section class="dashboard-panel" id="navPanel">
            <div class="panel-header tinted">
                <div>
                    <h3 class="section-title">🧭 Navigasi ke Stasiun Pengisian</h3>
                    <div class="section-subtitle">Temukan stasiun terdekat dari posisi Anda, pilih tujuan, lalu ikuti rute mobil beserta estimasi waktu tiba.</div>
                </div>
                <div class="panel-actions">
                    <button type="button" class="btn" id="btnLocate">📍 Lokasi Saya</button>
                </div>
            </div>

            <div class="nav-layout">
                <div class="nav-side">
                    <div class="nav-status" id="navStatus">Klik "Lokasi Saya" untuk mencari stasiun terdekat.</div>

                    <!-- Kartu rute terpilih -->
                    <div class="route-card" id="routeCard">
                        <div class="route-dest" id="routeDest">-</div>
                        <div class="route-eta" id="routeEta">-</div>
                        <div class="route-sub" id="routeSub">-</div>
                        <div class="route-btns">
                            <button type="button" class="btn" id="btnStart">▶ Mulai Navigasi</button>
                            <button type="button" class="btn btn-light" id="btnCancel">✕ Batal</button>
                        </div>
                        <ul class="steps" id="routeSteps"></ul>
                    </div>

                    <div class="table-title">Stasiun Terdekat</div>
                    <div id="nearestList"><p class="empty-text">Belum ada data lokasi Anda.</p></div>
                </div>

                <div class="map-wrap">
                    <div id="map"></div>
                    <div class="nav-banner" id="navBanner">
                        <div class="arrow" id="bArrow">↑</div>
                        <div>
                            <div class="b-main" id="bMain">-</div>
                            <div class="b-sub" id="bSub">-</div>
                        </div>
                    </div>
                    <button type="button" class="map-fab" id="btnCenter" title="Pusatkan ke lokasi saya">🎯</button>
                </div>
            </div>
        </section>

        <!-- FITUR PENCARIAN LOKASI CHARGER -->
        <div class="search-box">
            <input type="text" id="search-station" placeholder="🔍 Cari berdasarkan nama stasiun atau alamat...">
        </div>

        <!-- DAFTAR STASIUN -->
        @if(isset($chargingStations) && $chargingStations->count() > 0)
            <div id="station-list" class="station-list">
                @foreach($chargingStations as $station)
                    <section class="station-card dashboard-panel"
                         data-name="{{ strtolower($station->nama_st) }}"
                         data-address="{{ strtolower($station->alamat) }}">

                        <div class="panel-header tinted">
                            <div>
                                <h3 class="section-title">{{ $station->nama_st }}</h3>
                                <div class="section-subtitle">📍 {{ $station->alamat }}</div>
                            </div>
                            <div class="panel-actions">
                                @php
                                    $statusColor = '';
                                    if(strtolower($station->status ?? '') == 'aktif' || strtolower($station->status ?? '') == 'tersedia') {
                                        $statusColor = 'green';
                                    } elseif(strtolower($station->status ?? '') == 'maintenance' || strtolower($station->status ?? '') == 'perbaikan') {
                                        $statusColor = 'orange';
                                    }
                                @endphp
                                <span class="badge {{ $statusColor }}">Status: {{ ucfirst($station->status ?? 'Aktif') }}</span>
                                <span class="panel-count">Total Unit: {{ $station->chargers->count() }} Charger</span>

                                @if($station->latitude && $station->longitude)
                                    @if($station->chargers->where('status', 'tersedia')->count() > 0)
                                        <button type="button" class="btn btn-sm"
                                                onclick="pilihStasiun('{{ $station->getKey() }}')">
                                            🧭 Rute ke Sini
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="pilihStasiun('{{ $station->getKey() }}')">
                                            ⛔ Tidak Tersedia
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-title">Daftar Perangkat Charger, Konektor &amp; Tarif</div>
                            @if($station->chargers->count() > 0)
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Kode Charger</th>
                                                <th>Jenis Konektor</th>
                                                <th>Daya Maks</th>
                                                <th>Tarif / kWh</th>
                                                <th>Status Real-Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($station->chargers as $charger)
                                                @php
                                                    $konektorName = $charger->konektor ? $charger->konektor->nm_konektor : '-';
                                                    $jenisCharging = $charger->konektor ? $charger->konektor->jenis_charging : '-';
                                                    // Ambil tarif terbaru
                                                    $tarifStr = 'Belum diatur';
                                                    if ($charger->tarifs && $charger->tarifs->count() > 0) {
                                                        $latestTarif = $charger->tarifs->sortByDesc('berlaku_mulai')->first();
                                                        $tarifStr = 'Rp ' . number_format($latestTarif->harga_per_kWh, 0, ',', '.');
                                                    }

                                                    // Warna badge status real-time
                                                    $badge = '';
                                                    if ($charger->status === 'tersedia') {
                                                        $badge = 'green';
                                                    } elseif ($charger->status === 'digunakan') {
                                                        $badge = 'blue';
                                                    } elseif ($charger->status === 'error') {
                                                        $badge = 'red';
                                                    } elseif ($charger->status === 'perbaikan') {
                                                        $badge = 'orange';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td><strong>{{ $charger->kd_charger }}</strong></td>
                                                    <td>{{ $konektorName }} <span class="hint">({{ $jenisCharging }})</span></td>
                                                    <td>{{ $charger->daya_maks }} kW</td>
                                                    <td><strong>{{ $tarifStr }}</strong></td>
                                                    <td><span class="badge {{ $badge }}">{{ ucfirst($charger->status) }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="empty-text">Belum ada perangkat charger yang terdaftar di stasiun ini.</p>
                            @endif
                        </div>
                    </section>
                @endforeach
            </div>
        @else
            <div class="empty-box">Belum ada data lokasi stasiun yang tersedia di database.</div>
        @endif

    </main>

    <!-- ===== MODAL: STASIUN TIDAK BISA DIGUNAKAN ===== -->
    <div class="modal-overlay" id="uaModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="uaTitle">Stasiun sedang tidak bisa digunakan</h3>
                <button type="button" class="modal-close" onclick="tutupTidakTersedia()">×</button>
            </div>
            <div id="uaBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="tutupTidakTersedia()">Mengerti</button>
            </div>
        </div>
    </div>

    <!-- Leaflet JS untuk Peta -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        /* =====================================================
         *  NAVIGASI ALA GOOGLE MAPS
         *  - Lokasi real-time   : navigator.geolocation.watchPosition
         *  - Stasiun terdekat   : Haversine + OSRM Table (jarak & waktu jalan)
         *  - Rute mobil + ETA   : OSRM Route (profil driving)
         *  - Ikuti rute         : snap ke rute, reroute otomatis, notifikasi belokan
         *  - Stasiun tanpa charger tersedia tidak bisa dipilih (ditampilkan alasannya)
         * ===================================================== */
        const STATIONS = @json($stationsData);
        const OSRM = 'https://router.project-osrm.org';   // server demo; untuk produksi gunakan server OSRM/ORS sendiri

        let map, userMarker, accCircle, routeCasing, routeLine;
        let userPos = null, watchId = null, firstFix = true;
        let selected = null, route = null, pendingId = null;
        let navigating = false, follow = true, lastReroute = 0, lastNearestPos = null, wakeLock = null;
        const stationMarkers = {};

        const $ = id => document.getElementById(id);
        const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

        // Stasiun dianggap tidak bisa digunakan jika tidak ada satu pun charger yang tersedia
        const isDown = s => s.tersedia === 0;

        /* ---------- Helper ---------- */
        function hav4(la1, ln1, la2, ln2) {
            const R = 6371000, r = Math.PI / 180;
            const dLa = (la2 - la1) * r, dLn = (ln2 - ln1) * r;
            const a = Math.sin(dLa / 2) ** 2 + Math.cos(la1 * r) * Math.cos(la2 * r) * Math.sin(dLn / 2) ** 2;
            return 2 * R * Math.asin(Math.sqrt(a));
        }
        const hav = (a, b) => hav4(a.lat, a.lng, b.lat, b.lng);

        function fmtDist(m) {
            return m < 1000 ? Math.round(m) + ' m' : (m / 1000).toFixed(1).replace('.', ',') + ' km';
        }
        function fmtDur(s) {
            const m = Math.max(1, Math.round(s / 60));
            if (m < 60) return m + ' mnt';
            const h = Math.floor(m / 60), mm = m % 60;
            return h + ' jam' + (mm ? ' ' + mm + ' mnt' : '');
        }
        function fmtClock(d) {
            return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
        }
        function setStatus(msg, type) {
            const el = $('navStatus');
            el.textContent = msg;
            el.className = 'nav-status' + (type ? ' ' + type : '');
        }

        /* ---------- Peta ---------- */
        map = L.map('map').setView([-7.7956, 110.3695], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        map.on('dragstart', () => { if (navigating) follow = false; });

        function pinIcon(sel, down) {
            return L.divIcon({
                className: '',
                html: '<div class="ev-pin' + (down ? ' down' : '') + (sel ? ' sel' : '') + '"><span>⚡</span></div>',
                iconSize: [30, 30], iconAnchor: [15, 30], popupAnchor: [0, -28]
            });
        }

        STATIONS.forEach(s => {
            const down = isDown(s);
            const m = L.marker([s.lat, s.lng], { icon: pinIcon(false, down) }).addTo(map);
            const tombol = down
                ? '<small style="color:#b91c1c;font-weight:700">⛔ Sedang tidak bisa digunakan</small><br>' +
                  '<button class="btn btn-sm btn-danger" style="margin-top:6px" onclick="pilihStasiun(\'' + esc(s.id) + '\')">Lihat alasan</button>'
                : '<button class="btn btn-sm" style="margin-top:6px" onclick="pilihStasiun(\'' + esc(s.id) + '\')">🧭 Rute ke sini</button>';
            m.bindPopup(
                '<b>' + esc(s.nama) + '</b><br><small>' + esc(s.alamat) + '</small><br>' +
                '<small>' + s.tersedia + ' dari ' + s.total + ' charger tersedia</small><br>' + tombol
            );
            stationMarkers[s.id] = m;
        });
        if (STATIONS.length) {
            map.fitBounds(L.latLngBounds(STATIONS.map(s => [s.lat, s.lng])), { padding: [40, 40], maxZoom: 14 });
        }

        /* ---------- Geolocation (real-time) ---------- */
        function startTracking() {
            if (!navigator.geolocation) {
                setStatus('Browser Anda tidak mendukung geolocation.', 'err');
                return;
            }
            if (watchId !== null) return;
            setStatus('Mencari lokasi Anda...');
            watchId = navigator.geolocation.watchPosition(onPos, onPosError, {
                enableHighAccuracy: true, maximumAge: 1000, timeout: 15000
            });
        }

        function onPosError(err) {
            const msg = {
                1: 'Izin lokasi ditolak. Aktifkan izin lokasi di browser lalu coba lagi.',
                2: 'Lokasi tidak tersedia. Pastikan GPS/Location aktif.',
                3: 'Waktu pencarian lokasi habis. Coba lagi.'
            }[err.code] || 'Gagal mendapatkan lokasi.';
            setStatus(msg + (location.protocol === 'http:' && location.hostname !== 'localhost' ? ' (Geolocation butuh HTTPS atau localhost.)' : ''), 'err');
            if (err.code === 1 || err.code === 2) { stopWatch(); }
        }

        function stopWatch() {
            if (watchId !== null) { navigator.geolocation.clearWatch(watchId); watchId = null; }
            firstFix = true;
        }

        function onPos(p) {
            userPos = { lat: p.coords.latitude, lng: p.coords.longitude, acc: p.coords.accuracy };

            if (!userMarker) {
                userMarker = L.marker([userPos.lat, userPos.lng], {
                    icon: L.divIcon({ className: '', html: '<div class="user-dot"></div>', iconSize: [18, 18], iconAnchor: [9, 9] }),
                    zIndexOffset: 1000
                }).addTo(map).bindPopup('<b>📍 Posisi Anda</b>');
                accCircle = L.circle([userPos.lat, userPos.lng], { radius: userPos.acc, color: '#1a73e8', weight: 1, fillOpacity: .08 }).addTo(map);
            } else {
                userMarker.setLatLng([userPos.lat, userPos.lng]);
                accCircle.setLatLng([userPos.lat, userPos.lng]).setRadius(userPos.acc);
            }

            if (firstFix) {
                firstFix = false;
                setStatus('Lokasi ditemukan (akurasi ±' + Math.round(userPos.acc) + ' m).', 'ok');
                renderNearest();
                if (pendingId) { const id = pendingId; pendingId = null; pilihStasiun(id); }
                else if (STATIONS.length) {
                    const near = STATIONS.slice().sort((a, b) => hav(userPos, a) - hav(userPos, b))[0];
                    map.fitBounds(L.latLngBounds([[userPos.lat, userPos.lng], [near.lat, near.lng]]), { padding: [60, 60], maxZoom: 16 });
                } else { map.setView([userPos.lat, userPos.lng], 15); }
            } else if (!navigating && lastNearestPos && hav(userPos, lastNearestPos) > 300) {
                renderNearest();   // perbarui daftar jika sudah berpindah > 300 m
            }

            if (navigating) {
                updateNavigation();
                if (follow) map.setView([userPos.lat, userPos.lng], Math.max(map.getZoom(), 17), { animate: true });
            }
        }

        /* ---------- Stasiun terdekat ---------- */
        async function renderNearest() {
            if (!userPos || !STATIONS.length) return;
            lastNearestPos = { lat: userPos.lat, lng: userPos.lng };

            const list = STATIONS.map(s => Object.assign({}, s, { jarak: hav(userPos, s) }))
                                 .sort((a, b) => a.jarak - b.jarak).slice(0, 5);
            drawNearest(list);

            // Perbarui dengan jarak & waktu tempuh jalan raya (mobil)
            try {
                const coords = [userPos, ...list].map(p => p.lng + ',' + p.lat).join(';');
                const dest = list.map((_, i) => i + 1).join(';');
                const r = await fetch(OSRM + '/table/v1/driving/' + coords + '?sources=0&destinations=' + dest + '&annotations=duration,distance');
                const d = await r.json();
                if (d.code === 'Ok') {
                    list.forEach((s, i) => { s.durasi = d.durations[0][i]; s.jalan = d.distances[0][i]; });
                    list.sort((a, b) => (a.durasi ?? Infinity) - (b.durasi ?? Infinity));
                    drawNearest(list);
                }
            } catch (e) { /* tetap tampilkan jarak garis lurus */ }
        }

        function drawNearest(list) {
            if (!list.length) { $('nearestList').innerHTML = '<p class="empty-text">Belum ada stasiun dengan koordinat.</p>'; return; }
            $('nearestList').innerHTML = list.map((s, i) => {
                const down = isDown(s);
                const jarak = s.jalan != null ? fmtDist(s.jalan) : '~' + fmtDist(s.jarak) + ' (lurus)';
                const eta = s.durasi != null ? ' · 🚗 ' + fmtDur(s.durasi) : '';
                const badge = s.tersedia > 0 ? 'green' : 'red';
                return '<div class="st-item' + (down ? ' down' : '') + (selected && selected.id === s.id ? ' selected' : '') + '" onclick="pilihStasiun(\'' + esc(s.id) + '\')">' +
                    '<div class="st-name">' + (i + 1) + '. ' + esc(s.nama) + '</div>' +
                    '<div class="st-addr">' + esc(s.alamat) + '</div>' +
                    '<div class="st-meta"><span class="panel-count">' + jarak + eta + '</span>' +
                    '<span class="badge ' + badge + '">' + s.tersedia + '/' + s.total + ' tersedia</span></div>' +
                    (down ? '<div class="st-warn">⛔ Sedang tidak bisa digunakan · klik untuk melihat alasan</div>' : '') +
                    '</div>';
            }).join('');
        }

        /* ---------- Stasiun tidak tersedia: tampilkan alasan ---------- */
        const STATUS_LABEL = { perbaikan: 'Sedang maintenance', error: 'Mengalami error', digunakan: 'Sedang digunakan' };
        const STATUS_BADGE = { perbaikan: 'orange', error: 'red', digunakan: 'blue' };
        const STATUS_TEXT  = {
            perbaikan: 'Charger sedang dalam perawatan.',
            error: 'Charger mengalami gangguan dan menunggu penanganan.',
            digunakan: 'Charger sedang dipakai pengemudi lain.'
        };
        const MT_LABEL = { dijadwalkan: 'Dijadwalkan', proses: 'Dalam proses' };

        function alasanCharger(m) {
            const label = STATUS_LABEL[m.status] || (m.status ? m.status.charAt(0).toUpperCase() + m.status.slice(1) : 'Tidak tersedia');
            const warna = STATUS_BADGE[m.status] || '';
            let detail = STATUS_TEXT[m.status] || 'Charger tidak tersedia saat ini.';

            // Keterangan dari data maintenance yang masih berjalan
            if (m.jenis || m.keterangan) {
                detail += '<br><b>Maintenance:</b> ' +
                    (m.jenis ? esc(m.jenis) : '') +
                    (m.status_mt ? ' · ' + esc(MT_LABEL[m.status_mt] || m.status_mt) : '') +
                    (m.tgl ? ' · jadwal ' + esc(m.tgl) : '') +
                    (m.keterangan ? '<br>' + esc(m.keterangan) : '');
            } else if (m.status === 'perbaikan') {
                detail += '<br><i>Belum ada catatan maintenance.</i>';
            }

            return '<li><div class="ua-head"><strong>' + esc(m.kode) + '</strong>' +
                   '<span class="badge ' + warna + '">' + esc(label) + '</span></div>' +
                   '<div class="ua-detail">' + detail + '</div></li>';
        }

        function tampilkanTidakTersedia(s) {
            $('uaTitle').textContent = '⛔ ' + s.nama + ' sedang tidak bisa digunakan';

            let html;
            if (s.total === 0) {
                html = '<p class="ua-intro">Belum ada charger yang terdaftar di stasiun ini, sehingga rute tidak dapat dipilih.</p>';
            } else {
                html = '<p class="ua-intro">Rute tidak dapat dipilih karena tidak ada charger yang tersedia (0 dari ' + s.total +
                       ' charger). Penyebabnya:</p><ul class="ua-list">' + s.masalah.map(alasanCharger).join('') + '</ul>';
            }
            $('uaBody').innerHTML = html;
            $('uaModal').classList.add('active');
        }

        function tutupTidakTersedia() { $('uaModal').classList.remove('active'); }
        $('uaModal').addEventListener('click', e => { if (e.target.id === 'uaModal') tutupTidakTersedia(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupTidakTersedia(); });

        /* ---------- Pilih stasiun & ambil rute ---------- */
        function pilihStasiun(id) {
            const s = STATIONS.find(x => x.id === String(id));
            if (!s) return;
            map.closePopup();

            // Stasiun tanpa charger tersedia: jangan buat rute, tampilkan alasannya
            if (isDown(s)) {
                tampilkanTidakTersedia(s);
                return;
            }

            $('navPanel').scrollIntoView({ behavior: 'smooth', block: 'start' });

            if (!userPos) {            // belum ada lokasi: minta dulu, rute otomatis diambil setelah lokasi ketemu
                pendingId = s.id;
                startTracking();
                return;
            }
            STATIONS.forEach(x => stationMarkers[x.id].setIcon(pinIcon(x.id === s.id, isDown(x))));
            selected = s;
            if (navigating) stopNavigation(true);
            fetchRoute(userPos, s, false);
            renderNearest();
        }

        async function fetchRoute(from, to, isReroute) {
            setStatus(isReroute ? 'Menghitung ulang rute...' : 'Mencari rute tercepat...');
            try {
                const url = OSRM + '/route/v1/driving/' + from.lng + ',' + from.lat + ';' + to.lng + ',' + to.lat +
                            '?overview=full&geometries=geojson&steps=true';
                const r = await fetch(url);
                const d = await r.json();
                if (d.code !== 'Ok' || !d.routes.length) throw new Error('Rute tidak ditemukan');

                const rt = d.routes[0];
                const coords = rt.geometry.coordinates.map(c => [c[1], c[0]]);
                const cum = [0];
                for (let i = 1; i < coords.length; i++) {
                    cum.push(cum[i - 1] + hav4(coords[i - 1][0], coords[i - 1][1], coords[i][0], coords[i][1]));
                }
                const total = cum[cum.length - 1] || 1;
                const k = total / (rt.distance || total);
                const steps = rt.legs[0].steps;
                let acc = 0;
                const starts = steps.map(s => { const v = acc; acc += s.distance * k; return v; });

                route = { coords, cum, total, distance: rt.distance, duration: rt.duration, steps, starts };
                drawRoute(coords);
                showRouteCard();
                setStatus('Rute ditemukan.', 'ok');
                if (!navigating) map.fitBounds(L.polyline(coords).getBounds(), { padding: [60, 60] });
            } catch (e) {
                setStatus('Gagal mengambil rute: ' + e.message + '. Periksa koneksi internet Anda.', 'err');
            }
        }

        function drawRoute(latlngs) {
            if (routeCasing) map.removeLayer(routeCasing);
            if (routeLine) map.removeLayer(routeLine);
            routeCasing = L.polyline(latlngs, { color: '#fff', weight: 10, opacity: .95 }).addTo(map);
            routeLine = L.polyline(latlngs, { color: '#1a73e8', weight: 6, opacity: .95 }).addTo(map);
        }

        /* ---------- Teks instruksi belokan ---------- */
        function stepInfo(st) {
            const m = st.maneuver || {}, mod = m.modifier || '', type = m.type || '';
            const arrows = { 'left': '↰', 'right': '↱', 'slight left': '↖', 'slight right': '↗', 'sharp left': '↰', 'sharp right': '↱', 'straight': '↑', 'uturn': '↶' };
            const dir = {
                'left': 'kiri', 'right': 'kanan', 'slight left': 'sedikit ke kiri', 'slight right': 'sedikit ke kanan',
                'sharp left': 'tajam ke kiri', 'sharp right': 'tajam ke kanan'
            };
            const jalan = st.name ? ' ke ' + st.name : '';
            let text, icon = arrows[mod] || '↑';

            if (type === 'depart') { text = 'Mulai berkendara' + (st.name ? ' di ' + st.name : ''); icon = '🚗'; }
            else if (type === 'arrive') { text = 'Anda tiba di tujuan'; icon = '🏁'; }
            else if (mod === 'uturn') { text = 'Putar balik' + jalan; }
            else if (type === 'roundabout' || type === 'rotary' || type === 'roundabout turn') {
                text = 'Masuk bundaran' + (m.exit ? ', ambil exit ke-' + m.exit : '') + jalan; icon = '⟳';
            }
            else if (type === 'fork') { text = 'Ambil jalur ' + (mod.includes('left') ? 'kiri' : 'kanan') + jalan; }
            else if (type === 'merge') { text = 'Bergabung ke jalur' + jalan; }
            else if (type === 'on ramp' || type === 'off ramp') { text = 'Ambil jalur ' + (type === 'on ramp' ? 'masuk' : 'keluar') + jalan; }
            else if (type === 'end of road' && dir[mod]) { text = 'Di ujung jalan, belok ' + dir[mod] + jalan; }
            else if (type === 'turn' && dir[mod]) { text = 'Belok ' + dir[mod] + jalan; }
            else if (mod === 'straight' || type === 'continue' || type === 'new name') { text = 'Lanjutkan lurus' + jalan; icon = '↑'; }
            else { text = 'Lanjutkan' + jalan; }
            return { text, icon };
        }

        /* ---------- Kartu rute ---------- */
        function showRouteCard() {
            if (!route || !selected) return;
            const eta = new Date(Date.now() + route.duration * 1000);
            $('routeDest').textContent = 'Menuju ' + selected.nama;
            $('routeEta').textContent = fmtDur(route.duration);
            $('routeSub').textContent = fmtDist(route.distance) + ' · Tiba sekitar ' + fmtClock(eta) + ' (mobil)';
            $('routeSteps').innerHTML = route.steps.map(st => {
                const i = stepInfo(st);
                return '<li><span class="ic">' + i.icon + '</span><span>' + esc(i.text) + '</span><span class="dist">' + (st.distance ? fmtDist(st.distance) : '') + '</span></li>';
            }).join('');
            $('routeCard').classList.add('show');
        }

        /* ---------- Mode navigasi (ikuti rute) ---------- */
        function snapToRoute(pos) {
            const kx = 111320 * Math.cos(pos.lat * Math.PI / 180), ky = 110540;
            let best = { dist: Infinity, idx: 0, along: 0, lat: pos.lat, lng: pos.lng };
            for (let i = 0; i < route.coords.length - 1; i++) {
                const a = route.coords[i], b = route.coords[i + 1];
                const ax = (a[1] - pos.lng) * kx, ay = (a[0] - pos.lat) * ky;
                const bx = (b[1] - pos.lng) * kx, by = (b[0] - pos.lat) * ky;
                const dx = bx - ax, dy = by - ay, len2 = dx * dx + dy * dy;
                let t = len2 ? -(ax * dx + ay * dy) / len2 : 0;
                t = Math.max(0, Math.min(1, t));
                const dist = Math.hypot(ax + t * dx, ay + t * dy);
                if (dist < best.dist) {
                    best = {
                        dist, idx: i,
                        along: route.cum[i] + t * (route.cum[i + 1] - route.cum[i]),
                        lat: a[0] + t * (b[0] - a[0]), lng: a[1] + t * (b[1] - a[1])
                    };
                }
            }
            return best;
        }

        async function startNavigation() {
            if (!route || !userPos) return;
            navigating = true; follow = true;
            $('btnStart').textContent = '⏹ Hentikan';
            $('navBanner').classList.add('show');
            try { if ('wakeLock' in navigator) wakeLock = await navigator.wakeLock.request('screen'); } catch (e) {}
            map.setView([userPos.lat, userPos.lng], 17);
            updateNavigation();
        }

        function stopNavigation(silent) {
            navigating = false;
            $('btnStart').textContent = '▶ Mulai Navigasi';
            $('navBanner').classList.remove('show');
            if (wakeLock) { wakeLock.release().catch(() => {}); wakeLock = null; }
            if (!silent && route) { drawRoute(route.coords); showRouteCard(); }
        }

        function updateNavigation() {
            if (!route || !selected || !userPos) return;

            // Tiba di tujuan
            if (hav(userPos, selected) < 40) {
                stopNavigation(true);
                $('navBanner').classList.add('show');
                $('bArrow').textContent = '🏁';
                $('bMain').textContent = 'Anda telah tiba di ' + selected.nama;
                $('bSub').textContent = 'Navigasi selesai';
                setStatus('Anda telah tiba di tujuan.', 'ok');
                return;
            }

            const snap = snapToRoute(userPos);

            // Keluar jalur > 60 m: hitung ulang rute
            if (snap.dist > 60 && Date.now() - lastReroute > 8000) {
                lastReroute = Date.now();
                $('bArrow').textContent = '⟳';
                $('bMain').textContent = 'Menghitung ulang rute...';
                $('bSub').textContent = 'Anda keluar dari jalur';
                fetchRoute(userPos, selected, true);
                return;
            }

            const remain = Math.max(0, route.total - snap.along);
            const remDur = route.duration * (remain / route.total);
            const eta = new Date(Date.now() + remDur * 1000);

            // Gambar sisa rute saja (bagian yang sudah dilalui dihilangkan)
            const rest = [[snap.lat, snap.lng]].concat(route.coords.slice(snap.idx + 1));
            routeCasing.setLatLngs(rest);
            routeLine.setLatLngs(rest);

            // Belokan berikutnya
            let n = route.steps.length - 1;
            for (let i = 1; i < route.steps.length; i++) {
                if (route.starts[i] > snap.along + 5) { n = i; break; }
            }
            const info = stepInfo(route.steps[n]);
            const dNext = Math.max(0, route.starts[n] - snap.along);
            $('bArrow').textContent = info.icon;
            $('bMain').textContent = (dNext > 15 ? 'Dalam ' + fmtDist(dNext) + ': ' : '') + info.text;
            $('bSub').textContent = fmtDur(remDur) + ' · ' + fmtDist(remain) + ' lagi · Tiba ' + fmtClock(eta);

            $('routeEta').textContent = fmtDur(remDur);
            $('routeSub').textContent = fmtDist(remain) + ' · Tiba sekitar ' + fmtClock(eta) + ' (mobil)';
        }

        function cancelRoute() {
            stopNavigation(true);
            selected = null; route = null;
            if (routeCasing) { map.removeLayer(routeCasing); routeCasing = null; }
            if (routeLine) { map.removeLayer(routeLine); routeLine = null; }
            STATIONS.forEach(x => stationMarkers[x.id].setIcon(pinIcon(false, isDown(x))));
            $('routeCard').classList.remove('show');
            setStatus(userPos ? 'Rute dibatalkan. Pilih stasiun lain.' : 'Klik "Lokasi Saya" untuk mencari stasiun terdekat.');
            if (userPos) renderNearest();
        }

        /* ---------- Tombol ---------- */
        $('btnLocate').addEventListener('click', () => {
            if (watchId === null) startTracking();
            else if (userPos) { follow = true; map.setView([userPos.lat, userPos.lng], Math.max(map.getZoom(), 15)); renderNearest(); }
        });
        $('btnCenter').addEventListener('click', () => {
            if (watchId === null) startTracking();
            else if (userPos) { follow = true; map.setView([userPos.lat, userPos.lng], Math.max(map.getZoom(), 16)); }
        });
        $('btnStart').addEventListener('click', () => { navigating ? stopNavigation(false) : startNavigation(); });
        $('btnCancel').addEventListener('click', cancelRoute);

        /* ---------- Pencarian kartu stasiun ---------- */
        $('search-station').addEventListener('input', function (e) {
            const keyword = e.target.value.toLowerCase();
            document.querySelectorAll('.station-card').forEach(function (card) {
                const name = card.getAttribute('data-name');
                const address = card.getAttribute('data-address');
                card.style.display = (name.includes(keyword) || address.includes(keyword)) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>