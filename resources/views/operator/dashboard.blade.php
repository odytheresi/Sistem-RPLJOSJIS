<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Operator - EVChargeHub</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f5f7fb;
        color: #172033;
        display: flex;
        min-height: 100vh;
    }

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
    .sidebar nav a:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateX(3px);
    }
    .sidebar nav a.active {
        background: rgba(255, 255, 255, 0.28);
        border-color: rgba(255, 255, 255, 0.5);
        color: #fff;
        font-weight: 700;
    }

    /* ===== MAIN ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .topbar h2 { font-size: 22px; font-weight: 800; color: #172033; }
    .operator-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid #e8edf4;
        box-shadow: 0 4px 16px #16274805;
    }
    .operator-badge .avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: #3d9e71;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 13px;
    }
    .operator-badge .info small { color: #8390a5; display: block; font-size: 11px; }
    .operator-badge .info strong { font-size: 13px; color: #172033; }

    /* ===== WELCOME PANEL ===== */
    .welcome-panel {
        padding: 28px;
        border-radius: 18px;
        background: linear-gradient(115deg, #3d9e71, #62b98e);
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .welcome-panel h3 { font-size: 23px; font-weight: 800; margin: 0 0 10px; }
    .welcome-panel p { color: #e6f5ed; font-size: 13px; margin: 0; max-width: 520px; line-height: 1.8; }
    .section-title { font-size: 16px; font-weight: 800; margin: 0; }
    .section-subtitle { color: #8390a5; font-size: 12px; margin-top: 5px; }

    /* ===== STAT CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 17px;
        margin: 20px 0 30px;
    }
    .stat-card {
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        padding: 21px;
        box-shadow: 0 4px 16px #16274805;
        min-width: 0;
    }
    .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .stat-icon {
        width: 43px; height: 43px;
        display: grid; place-items: center;
        border-radius: 12px;
        font-size: 20px;
    }
    .blue { background: #e0f1e8; }
    .green { background: #dcfce7; }
    .orange { background: #ffedd5; }
    .red { background: #fee2e2; }
    .stat-label { font-size: 12px; color: #77849a; font-weight: 600; margin-top: 17px; }
    .stat-value { font-size: 30px; font-weight: 800; letter-spacing: -1px; margin-top: 5px; color: #172033; }
    .stat-note { color: #98a2b3; font-size: 11px; margin-top: 5px; }

    /* ===== QUICK LINKS ===== */
    .quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin: 18px 0 30px;
    }
    .quick-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 17px;
        background: white;
        border: 1px solid #e7ecf3;
        border-radius: 14px;
        color: #172033;
        text-decoration: none;
        transition: .2s;
        min-width: 0;
    }
    .quick-link:hover {
        transform: translateY(-3px);
        border-color: #a6d8bf;
        box-shadow: 0 8px 22px #3d9e710c;
        color: #3d9e71;
    }
    .quick-icon {
        width: 43px; height: 43px; flex: 0 0 43px;
        display: grid; place-items: center;
        background: #e8f5ee;
        border-radius: 12px;
        font-size: 20px;
    }
    .quick-link strong { display: block; font-size: 12px; font-weight: 800; }
    .quick-link small { display: block; margin-top: 5px; color: #8390a5; font-size: 10px; }
    .quick-arrow { margin-left: auto; color: #9ba6b8; }

    /* ===== PANEL & TABLE ===== */
    .dashboard-panel {
        background: white;
        border: 1px solid #e7ecf3;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 25px;
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
    .panel-count {
        padding: 6px 10px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
    }
    .table-responsive { overflow-x: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        white-space: nowrap;
    }
    th {
        padding: 14px 18px;
        text-align: left;
        background: #f8fafc;
        color: #78869b;
        font-weight: 700;
        border-bottom: 1px solid #edf0f5;
    }
    td {
        padding: 15px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #475569;
    }
    tbody tr { cursor: pointer; transition: background 0.15s; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }

    .empty-state {
        text-align: center;
        padding: 28px !important;
        color: #98a2b3 !important;
        cursor: default;
    }

    /* ===== STATUS BADGE ===== */
    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
    }
    .badge.aktif, .badge.normal, .badge.tersedia { background: #dcfce7; color: #166534; }
    .badge.error, .badge.rusak, .badge.nonaktif { background: #fee2e2; color: #b91c1c; }
    .badge.digunakan, .badge.penuh { background: #dbeafe; color: #1d4ed8; }
    .badge.maintenance, .badge.perbaikan, .badge.dalam-perawatan, .badge.pending { background: #ffedd5; color: #9a3412; }

    /* ===== MODAL DETAIL ===== */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.5);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: all 0.2s ease;
        z-index: 999;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-box {
        background: #fff; width: 100%; max-width: 420px;
        border-radius: 15px; padding: 24px;
        border: 1px solid #e7ecf3;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(10px);
        transition: transform 0.2s ease;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; border-bottom: 1px solid #edf0f5; padding-bottom: 10px;
    }
    .modal-header h3 { font-size: 16px; font-weight: 800; color: #172033; }
    .modal-close {
        background: #f1f5f9; border: none; width: 28px; height: 28px;
        border-radius: 50%; cursor: pointer; color: #64748b; font-weight: bold;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-body { font-size: 13px; color: #475569; display: flex; flex-direction: column; gap: 8px; }
    .modal-body p strong { color: #172033; width: 120px; display: inline-block; }
    .modal-footer { margin-top: 20px; display: flex; justify-content: flex-end; }
    .btn-close {
        background: #3d9e71; color: #fff; border: none; padding: 8px 16px;
        border-radius: 9px; font-size: 12px; font-weight: 700; cursor: pointer;
    }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .quick-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
    }
    @media (max-width: 600px) {
        .stats-grid, .quick-grid { grid-template-columns: 1fr; }
        .welcome-panel { padding: 22px; }
        .welcome-panel h3 { font-size: 20px; }
    }
</style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="/operator/dashboard" class="active">📊 Dashboard</a>
            <a href="/operator/lokasi_stasiun">📍 Lokasi Stasiun</a>
            <a href="/operator/charger">🔌 Charger</a>
            <a href="/operator/tarif">💰 Tarif</a>
            <a href="/operator/keluhan">📝 Keluhan</a>
            <a href="/operator/maintenance">📈 Maintenance</a>
        </nav>
    </aside>

    <!-- ===== MAIN ===== -->
    <main class="main">

        <div class="topbar">
            <h2>Dashboard Operator</h2>
            <div class="operator-badge">
                <div class="avatar" id="avatar-initial">-</div>
                <div class="info">
                    <strong id="operator-name">Memuat...</strong>
                    <small id="operator-id">-</small>
                </div>
            </div>
        </div>

        <!-- ===== WELCOME ===== -->
        <div class="welcome-panel">
            <h3>Selamat datang di EVChargeHub 👋</h3>
            <p>
                Kelola stasiun pengisian kendaraan listrik, pantau charger,
                atur tarif, dan tindak lanjuti keluhan melalui satu dashboard.
            </p>
        </div>

        <div>
            <h3 class="section-title">Ringkasan Operasional Operator</h3>
            <div class="section-subtitle">Catatan Informasi Operasional Stasiun dan Charger</div>
        </div>

        <!-- ===== STAT SUMMARY ===== -->
        <div class="stats-grid" id="stats-grid">
            <!-- diisi oleh JS -->
        </div>

        <div>
            <h3 class="section-title">Akses Cepat</h3>
            <div class="section-subtitle">Pilih menu untuk mengelola data operasional.</div>
        </div>

        <div class="quick-grid">
            <a class="quick-link" href="/operator/lokasi_stasiun">
                <span class="quick-icon">📍</span>
                <span><strong>Kelola Stasiun</strong><small>Lihat dan atur lokasi stasiun</small></span>
                <span class="quick-arrow">›</span>
            </a>
            <a class="quick-link" href="/operator/charger">
                <span class="quick-icon">🔌</span>
                <span><strong>Kelola Charger</strong><small>Lihat daftar unit charger</small></span>
                <span class="quick-arrow">›</span>
            </a>
            <a class="quick-link" href="/operator/tarif">
                <span class="quick-icon">💰</span>
                <span><strong>Atur Tarif</strong><small>Lihat dan kelola tarif pengisian</small></span>
                <span class="quick-arrow">›</span>
            </a>
            <a class="quick-link" href="/operator/keluhan">
                <span class="quick-icon">📝</span>
                <span><strong>Kelola Keluhan</strong><small>Periksa laporan pengguna</small></span>
                <span class="quick-arrow">›</span>
            </a>
            <a class="quick-link" href="/operator/maintenance">
                <span class="quick-icon">🛠️</span>
                <span><strong>Maintenance</strong><small>Lihat data perawatan</small></span>
                <span class="quick-arrow">›</span>
            </a>
        </div>

        <!-- ===== CHARGING STATION ===== -->
        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Charging Station</h3>
                    <div class="section-subtitle">Data stasiun yang terdaftar.</div>
                </div>
                <span class="panel-count" id="station-count">0 lokasi</span>
            </div>
            <div class="table-responsive">
                <table id="station-table">
                    <thead>
                        <tr><th>ID</th><th>Nama Stasiun</th><th>Alamat</th><th>Status</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- ===== CHARGER ===== -->
        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Unit Charger</h3>
                    <div class="section-subtitle">Ringkasan unit charger terdaftar.</div>
                </div>
                <span class="panel-count" id="charger-count">0 unit</span>
            </div>
            <div class="table-responsive">
                <table id="charger-table">
                    <thead>
                        <tr><th>Kode</th><th>Stasiun</th><th>Konektor</th><th>Daya</th><th>Status Penggunaan</th><th>Kondisi</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- ===== TARIF ===== -->
        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Tarif</h3>
                    <div class="section-subtitle">Tarif pengisian yang tercatat.</div>
                </div>
                <span class="panel-count" id="tarif-count">0 tarif</span>
            </div>
            <div class="table-responsive">
                <table id="tarif-table">
                    <thead>
                        <tr><th>ID Tarif</th><th>Stasiun</th><th>Harga/kWh</th><th>Berlaku Mulai</th><th>Status</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>

        <!-- ===== KELUHAN ===== -->
        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Keluhan Pengguna</h3>
                    <div class="section-subtitle">Laporan keluhan yang tercatat.</div>
                </div>
                <span class="panel-count" id="keluhan-count">0 keluhan</span>
            </div>
            <div class="table-responsive">
                <table id="keluhan-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Stasiun</th><th>Pengemudi</th><th>Keluhan</th><th>Status</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>


    </main>

    <!-- ===== MODAL DETAIL ===== -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Detail Data</h3>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body" id="modalContent"></div>
            <div class="modal-footer">
                <button class="btn-close" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // ===== DATA DARI CONTROLLER LARAVEL =====
        const operator = @json($operator);
        const chargingStations = @json($chargingStations);
        const chargers = @json($chargers);
        const tarifs = @json($tarifs);
        const keluhan = @json($keluhan);

        // Angka statistik dari controller teman Anda
        const totalStationCount = {{ $totalStation }};
        const totalChargerCount = {{ $totalCharger }};
        const chargerAktifCount = {{ $chargerAktif }};
        const chargerNonaktifCount = {{ $chargerNonaktif }};
        const chargerMaintenanceCount = {{ $chargerMaintenance }};

        // ===== RENDER IDENTITAS OPERATOR =====
        document.getElementById('operator-name').textContent = operator.nama;
        document.getElementById('operator-id').textContent = 'ID Operator #' + operator.id_operator;
        document.getElementById('avatar-initial').textContent = operator.nama.charAt(0).toUpperCase();

        // ===== RENDER STAT CARDS =====
        document.getElementById('stats-grid').innerHTML = `
            <div class="stat-card">
                <div class="stat-top"><div class="stat-icon blue">📍</div></div>
                <div class="stat-label">Total Stasiun</div>
                <div class="stat-value">${totalStationCount}</div>
                <div class="stat-note">Stasiun terdaftar</div>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-icon green">🔌</div></div>
                <div class="stat-label">Charger Aktif</div>
                <div class="stat-value">${chargerAktifCount}/${totalChargerCount}</div>
                <div class="stat-note">Unit charger aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-icon orange">🛠️</div></div>
                <div class="stat-label">Maintenance</div>
                <div class="stat-value">${chargerMaintenanceCount}</div>
                <div class="stat-note">Charger dalam perawatan</div>
            </div>
            <div class="stat-card">
                <div class="stat-top"><div class="stat-icon red">⛔</div></div>
                <div class="stat-label">Non-Aktif</div>
                <div class="stat-value">${chargerNonaktifCount}</div>
                <div class="stat-note">Charger nonaktif</div>
            </div>
        `;

        function badgeClass(status) {
            if (!status) return '';
            return status.toLowerCase().replace(/\s+/g, '-');
        }

        // ===== RENDER CHARGING STATION (Tabel dengan onclick) =====
        const stationBody = document.querySelector('#station-table tbody');
        stationBody.innerHTML = '';
        chargingStations.forEach(cs => {
            const row = document.createElement('tr');
            row.setAttribute('onclick', `openModal('Charging Station', {
                'ID': '${cs.id}',
                'Nama Stasiun': '${cs.nama_st}',
                'Alamat': '${cs.alamat}',
                'Status': '${cs.status}'
            })`);

            row.innerHTML = `
                <td>${cs.id}</td>
                <td>${cs.nama_st}</td>
                <td>${cs.alamat}</td>
                <td><span class="badge ${badgeClass(cs.status)}">${cs.status}</span></td>
            `;
            stationBody.appendChild(row);
        });
        document.getElementById('station-count').textContent = chargingStations.length + ' lokasi';

        // ===== RENDER CHARGER (Tabel dengan onclick) =====
        const chargerBody = document.querySelector('#charger-table tbody');
        chargerBody.innerHTML = '';
        chargers.forEach(c => {
            const row = document.createElement('tr');
            const stationName = c.charging_station ? c.charging_station.nama_st : '-';
            const connectorName = c.tipe_konektor ? c.tipe_konektor.nm_konektor : '-';

            row.setAttribute('onclick', `openModal('Unit Charger', {
                'Kode Charger': '${c.kd_charger}',
                'Stasiun': '${stationName}',
                'Konektor': '${connectorName}',
                'Daya': '${c.daya_maks ?? c.daya} kW',
                'Status Penggunaan': '${c.status ?? 'Tersedia'}'
            })`);

            row.innerHTML = `
                <td>${c.kd_charger}</td>
                <td>${stationName}</td>
                <td>${connectorName}</td>
                <td>${c.daya_maks ?? c.daya} kW</td>
                <td><span class="badge ${badgeClass(c.status ?? 'Tersedia')}">${c.status ?? 'Tersedia'}</span></td>
                <td><span class="badge normal">Normal</span></td>
            `;
            chargerBody.appendChild(row);
        });
        document.getElementById('charger-count').textContent = chargers.length + ' unit';

        // ===== RENDER TARIF (Tabel dengan onclick) =====
        const tarifBody = document.querySelector('#tarif-table tbody');
        tarifBody.innerHTML = '';
        tarifs.forEach(t => {
            const row = document.createElement('tr');
            const stationName = t.charger && t.charger.charging_station ? t.charger.charging_station.nama_st : '-';
            const harga = Number(t.harga_per_kWh ?? t.harga_per_kwh ?? 0).toLocaleString('id-ID');

            row.setAttribute('onclick', `openModal('Tarif', {
                'ID Tarif': '${t.id}',
                'Stasiun': '${stationName}',
                'Harga / kWh': 'Rp ${harga}',
                'Berlaku Mulai': '${t.berlaku_mulai}',
                'Status': 'Aktif'
            })`);

            row.innerHTML = `
                <td>${t.id}</td>
                <td>${stationName}</td>
                <td>Rp ${harga}</td>
                <td>${t.berlaku_mulai}</td>
                <td><span class="badge aktif">Aktif</span></td>
            `;
            tarifBody.appendChild(row);
        });
        document.getElementById('tarif-count').textContent = tarifs.length + ' tarif';

        // ===== RENDER KELUHAN =====
        const keluhanBody = document.querySelector('#keluhan-table tbody');
        keluhanBody.innerHTML = '';
        if (keluhan.length === 0) {
            keluhanBody.innerHTML = `<tr><td colspan="5" class="empty-state">Belum ada keluhan</td></tr>`;
        } else {
            keluhan.forEach(k => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${k.tanggal ?? '-'}</td>
                    <td>${k.stasiun ?? '-'}</td>
                    <td>${k.pengemudi ?? '-'}</td>
                    <td>${k.keluhan ?? '-'}</td>
                    <td><span class="badge maintenance">${k.status ?? 'Pending'}</span></td>
                `;
                keluhanBody.appendChild(row);
            });
        }
        document.getElementById('keluhan-count').textContent = keluhan.length + ' keluhan';

        // ===== FUNGSI MODAL =====
        function openModal(title, dataObj) {
            document.getElementById('modalTitle').textContent = title;
            const contentContainer = document.getElementById('modalContent');
            contentContainer.innerHTML = '';

            for (const [key, value] of Object.entries(dataObj)) {
                const p = document.createElement('p');
                p.innerHTML = `<strong>${key}:</strong> ${value}`;
                contentContainer.appendChild(p);
            }

            document.getElementById('detailModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
        }
    </script>

</body>
</html>