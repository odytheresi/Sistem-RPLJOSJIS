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

    /* ===== MODAL PETA ===== */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.5);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: all 0.2s ease; z-index: 999;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-box {
        background: #fff; width: 92%; max-width: 680px;
        border-radius: 15px; padding: 24px; border: 1px solid var(--line);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(10px); transition: transform 0.2s ease;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; border-bottom: 1px solid #edf0f5; padding-bottom: 10px;
    }
    .modal-header h3 { font-size: 16px; font-weight: 800; }
    .modal-close {
        background: #f1f5f9; border: none; width: 28px; height: 28px; border-radius: 50%;
        cursor: pointer; color: #64748b; font-weight: bold; font-size: 16px;
        display: flex; align-items: center; justify-content: center;
    }
    #modalMap { height: 400px; width: 100%; border-radius: 10px; z-index: 0; }
</style>
</head>
<body>

    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}" class="active">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ url('/operator/tarif') }}">💰 Tarif</a>
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
                                    <button type="button" class="btn btn-sm"
                                            onclick="openMapModal('{{ addslashes($station->nama_st) }}', {{ $station->latitude }}, {{ $station->longitude }})">
                                        🗺️ Lihat Peta
                                    </button>
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

    <!-- MODAL PETA LEAFLET -->
    <div class="modal-overlay" id="mapModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Peta Lokasi Stasiun</h3>
                <button type="button" class="modal-close" onclick="closeMapModal()">&times;</button>
            </div>
            <div id="modalMap"></div>
        </div>
    </div>

    <!-- Leaflet JS untuk Peta -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let modalMap = null;

        function openMapModal(namaStasiun, stationLat, stationLng) {
            document.getElementById('mapModal').classList.add('active');
            document.getElementById('modalTitle').innerText = 'Rute ke Lokasi: ' + namaStasiun;

            if (!modalMap) {
                modalMap = L.map('modalMap');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(modalMap);
            }

            modalMap.eachLayer(function (layer) {
                if (layer instanceof L.Marker || layer instanceof L.Polyline) {
                    modalMap.removeLayer(layer);
                }
            });

            const stationMarker = L.marker([stationLat, stationLng]).addTo(modalMap)
                .bindPopup('<b>' + namaStasiun + ' (SPKLU)</b>');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    const userMarker = L.marker([userLat, userLng], {
                        icon: L.divIcon({
                            className: 'custom-user-icon',
                            html: '<div style="background-color: #3b82f6; width: 14px; height: 14px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 6px rgba(0,0,0,0.6);"></div>',
                            iconSize: [14, 14]
                        })
                    }).addTo(modalMap).bindPopup('<b>📍 Posisi Anda Sekarang</b>');

                    const routeLine = L.polyline([
                        [userLat, userLng],
                        [stationLat, stationLng]
                    ], {
                        color: '#3d9e71',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: '6, 8'
                    }).addTo(modalMap);

                    const bounds = L.latLngBounds([[userLat, userLng], [stationLat, stationLng]]);
                    modalMap.fitBounds(bounds, { padding: [50, 50] });

                    stationMarker.openPopup();
                }, function(error) {
                    modalMap.setView([stationLat, stationLng], 15);
                    stationMarker.openPopup();
                }, { timeout: 10000 });
            } else {
                modalMap.setView([stationLat, stationLng], 15);
                stationMarker.openPopup();
            }

            setTimeout(() => {
                modalMap.invalidateSize();
            }, 250);
        }

        function closeMapModal() {
            document.getElementById('mapModal').classList.remove('active');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('mapModal');
            if (event.target === modal) {
                closeMapModal();
            }
        }

        document.getElementById('search-station').addEventListener('keyup', function(e) {
            let keyword = e.target.value.toLowerCase();
            let cards = document.querySelectorAll('.station-card');

            cards.forEach(function(card) {
                let name = card.getAttribute('data-name');
                let address = card.getAttribute('data-address');

                if (name.includes(keyword) || address.includes(keyword)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>