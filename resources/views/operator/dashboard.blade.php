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
        background: #f4f6f9;
        color: #1a1a1a;
        display: flex;
        min-height: 100vh;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 240px;
        background: linear-gradient(180deg, #0f172a, #1e293b);
        color: #fff;
        padding: 24px 16px;
        flex-shrink: 0;
    }
    .sidebar h1 {
        font-size: 18px;
        margin-bottom: 4px;
    }
    .sidebar .subtitle {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 32px;
    }
    .sidebar nav a {
        display: block;
        color: #cbd5e1;
        text-decoration: none;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 4px;
        font-size: 14px;
        transition: background 0.2s;
    }
    .sidebar nav a.active, .sidebar nav a:hover {
        background: #334155;
        color: #fff;
    }

    /* ===== MAIN ===== */
    .main { 
        flex: 1; 
        padding: 28px 32px; 
        overflow-x: auto;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .topbar h2 { font-size: 22px; font-weight: 600; color: #0f172a; }
    .operator-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        padding: 8px 14px;
        border-radius: 999px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
    }
    .operator-badge .avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: #2563eb;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 13px;
    }
    .operator-badge .info small { color: #64748b; display: block; font-size: 11px; }
    .operator-badge .info strong { font-size: 13px; color: #1e293b; }

    /* ===== STAT CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
    }
    .stat-card .label { font-size: 12px; color: #64748b; margin-bottom: 6px; font-weight: 500; }
    .stat-card .value { font-size: 24px; font-weight: 700; color: #0f172a; }
    .stat-card.green { border-left-color: #16a34a; }
    .stat-card.orange { border-left-color: #f59e0b; }
    .stat-card.red { border-left-color: #dc2626; }

    /* ===== CARD/PANEL ===== */
    .panel {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .panel-header h3 { font-size: 16px; font-weight: 600; color: #1e293b; }
    .panel-header .count {
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 999px;
        font-weight: 600;
    }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    th {
        text-align: left;
        padding: 10px 12px;
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        border-bottom: 1px solid #e2e8f0;
    }
    td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    tr {
        cursor: pointer;
        transition: background 0.15s;
    }
    tr:hover td { background: #f8fafc; }

    /* ===== STATUS BADGE ===== */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .badge.aktif, .badge.normal, .badge.tersedia { background: #dcfce7; color: #15803d; }
    .badge.maintenance, .badge.dalam-perawatan { background: #fef3c7; color: #b45309; }
    .badge.error, .badge.rusak, .badge.nonaktif { background: #fee2e2; color: #b91c1c; }
    .badge.digunakan, .badge.penuh { background: #dbeafe; color: #1d4ed8; }

    .empty-state {
        text-align: center;
        padding: 24px;
        color: #94a3b8;
        font-size: 13px;
    }

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
        border-radius: 12px; padding: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(10px);
        transition: transform 0.2s ease;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;
    }
    .modal-header h3 { font-size: 16px; color: #0f172a; }
    .modal-close {
        background: #f1f5f9; border: none; width: 28px; height: 28px;
        border-radius: 50%; cursor: pointer; color: #64748b; font-weight: bold;
        display: flex; align-items: center; justify-content: center;
    }
    .modal-body { font-size: 13.5px; color: #475569; display: flex; flex-direction: column; gap: 8px; }
    .modal-body p strong { color: #1e293b; width: 110px; display: inline-block; }
    .modal-footer { margin-top: 20px; display: flex; justify-content: flex-end; }
    .btn-close {
        background: #2563eb; color: #fff; border: none; padding: 7px 16px;
        border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;
    }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        body { flex-direction: column; }
        .sidebar { width: 100%; }
    }
</style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="#" class="active">📊 Dashboard</a>
            <a href="/operator/lokasi_stasiun">📍 Lokasi Stasiun</a>
            <a href="#">🔌 Charger</a>
            <a href="#">💰 Tarif</a>
            <a href="#">📝 Keluhan</a>
            <a href="#">📈 Laporan</a>
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

        <!-- ===== STAT SUMMARY ===== -->
        <div class="stats-grid" id="stats-grid">
            <!-- diisi oleh JS -->
        </div>

        <!-- ===== CHARGING STATION ===== -->
        <div class="panel">
            <div class="panel-header">
                <h3>Charging Station</h3>
                <span class="count" id="station-count">0 lokasi</span>
            </div>
            <table id="station-table">
                <thead>
                    <tr><th>ID</th><th>Nama Stasiun</th><th>Alamat</th><th>Status</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- ===== CHARGER ===== -->
        <div class="panel">
            <div class="panel-header">
                <h3>Unit Charger</h3>
                <span class="count" id="charger-count">0 unit</span>
            </div>
            <table id="charger-table">
                <thead>
                    <tr><th>Kode</th><th>Stasiun</th><th>Konektor</th><th>Daya</th><th>Status Penggunaan</th><th>Kondisi</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- ===== TARIF ===== -->
        <div class="panel">
            <div class="panel-header">
                <h3>Tarif</h3>
                <span class="count" id="tarif-count">0 tarif</span>
            </div>
            <table id="tarif-table">
                <thead>
                    <tr><th>ID Tarif</th><th>Stasiun</th><th>Harga/kWh</th><th>Berlaku Mulai</th><th>Status</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- ===== KELUHAN ===== -->
        <div class="panel">
            <div class="panel-header">
                <h3>Keluhan Pengguna</h3>
                <span class="count" id="keluhan-count">0 keluhan</span>
            </div>
            <table id="keluhan-table">
                <thead>
                    <tr><th>Tanggal</th><th>Stasiun</th><th>Pengemudi</th><th>Keluhan</th><th>Status</th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

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
                <div class="label">Total Stasiun</div>
                <div class="value">${totalStationCount}</div>
            </div>
            <div class="stat-card green">
                <div class="label">Charger Aktif</div>
                <div class="value">${chargerAktifCount}/${totalChargerCount}</div>
            </div>
            <div class="stat-card orange">
                <div class="label">Maintenance</div>
                <div class="value">${chargerMaintenanceCount}</div>
            </div>
            <div class="stat-card red">
                <div class="label">Non-Aktif</div>
                <div class="value">${chargerNonaktifCount}</div>
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