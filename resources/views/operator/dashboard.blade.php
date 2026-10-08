<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Operator - EVChargeHub</title>
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f0f2f5;
        color: #1a1a1a;
        display: flex;
        min-height: 100vh;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 230px;
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
    }
    .sidebar nav a.active, .sidebar nav a:hover {
        background: #334155;
        color: #fff;
    }

    /* ===== MAIN ===== */
    .main { flex: 1; padding: 28px 32px; }

    .topbar {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom: 24px;
    }
    .topbar h2 { font-size: 22px; }
    .operator-badge {
        display:flex;
        align-items:center;
        gap:10px;
        background:#fff;
        padding:8px 14px;
        border-radius: 999px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .operator-badge .avatar {
        width:32px; height:32px;
        border-radius:50%;
        background:#2563eb;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:bold;
        font-size:13px;
    }
    .operator-badge .info small { color:#64748b; display:block; font-size:11px; }

    /* ===== STAT CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background:#fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border-left: 4px solid #2563eb;
    }
    .stat-card .label { font-size:12px; color:#64748b; margin-bottom:6px; }
    .stat-card .value { font-size:24px; font-weight:700; }
    .stat-card.green { border-left-color:#16a34a; }
    .stat-card.orange { border-left-color:#f59e0b; }
    .stat-card.red { border-left-color:#dc2626; }

    /* ===== CARD/PANEL ===== */
    .panel {
        background:#fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .panel-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom: 14px;
    }
    .panel-header h3 { font-size: 16px; }
    .panel-header .count {
        background:#eff6ff;
        color:#2563eb;
        font-size:12px;
        padding:3px 10px;
        border-radius:999px;
        font-weight:600;
    }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    th {
        text-align:left;
        padding: 10px 12px;
        background:#f8fafc;
        color:#475569;
        font-weight:600;
        border-bottom: 1px solid #e2e8f0;
    }
    td {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    tr:hover td { background:#f8fafc; }

    /* ===== STATUS BADGE ===== */
    .badge {
        display:inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .badge.aktif, .badge.normal, .badge.tersedia { background:#dcfce7; color:#15803d; }
    .badge.maintenance, .badge.dalam-perawatan { background:#fef3c7; color:#b45309; }
    .badge.error, .badge.rusak, .badge.nonaktif { background:#fee2e2; color:#b91c1c; }
    .badge.digunakan, .badge.penuh { background:#dbeafe; color:#1d4ed8; }

    .empty-state {
        text-align:center;
        padding: 24px;
        color: #94a3b8;
        font-size: 13px;
    }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        body { flex-direction: column; }
        .sidebar { width:100%; }
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

    <script>
        // ===== DATA DUMMY (nanti diganti fetch() dari API Laravel) =====
        const operator = {
            id_operator: 1,
            nama: "Budi Santoso",
            user_id: 101
        };

        const chargingStations = [
            { id_station: 1, nama_st: "SPKLU Malioboro", alamat: "Jl. Malioboro No. 1, Yogyakarta", status: "Aktif" },
            { id_station: 2, nama_st: "SPKLU Slamet Riyadi", alamat: "Jl. Slamet Riyadi, Surakarta", status: "Dalam Perawatan" },
            { id_station: 3, nama_st: "SPKLU Jalan Solo", alamat: "Jl. Solo KM 8, Yogyakarta", status: "Penuh" },
        ];

        const chargers = [
            { kd_charger: "CHG-001", station: "SPKLU Malioboro", konektor: "CCS2", daya: "50 kW", penggunaan: "Tersedia", kondisi: "Normal" },
            { kd_charger: "CHG-002", station: "SPKLU Malioboro", konektor: "Type 2", daya: "22 kW", penggunaan: "Digunakan", kondisi: "Normal" },
            { kd_charger: "CHG-003", station: "SPKLU Slamet Riyadi", konektor: "CCS2", daya: "50 kW", penggunaan: "Tersedia", kondisi: "Error" },
        ];

        const tarifs = [
            { id_tarif: 1, station: "SPKLU Malioboro", harga_per_kwh: 2500, berlaku_mulai: "2026-01-01", status: "Aktif" },
            { id_tarif: 2, station: "SPKLU Slamet Riyadi", harga_per_kwh: 2300, berlaku_mulai: "2026-02-15", status: "Aktif" },
        ];

        const keluhan = [
            { tanggal: "2026-09-28", station: "SPKLU Slamet Riyadi", pengemudi: "Andi Wijaya", isi: "Charger error saat digunakan", status: "Diproses" },
            { tanggal: "2026-09-25", station: "SPKLU Jalan Solo", pengemudi: "Sari Dewi", isi: "Slot parkir penuh terus", status: "Selesai" },
        ];

        // ===== RENDER IDENTITAS OPERATOR =====
        document.getElementById('operator-name').textContent = operator.nama;
        document.getElementById('operator-id').textContent = 'ID Operator #' + operator.id_operator;
        document.getElementById('avatar-initial').textContent = operator.nama.charAt(0).toUpperCase();

        // ===== RENDER STAT CARDS =====
        const totalCharger = chargers.length;
        const chargerTersedia = chargers.filter(c => c.penggunaan === 'Tersedia').length;
        const chargerError = chargers.filter(c => c.kondisi === 'Error').length;

        document.getElementById('stats-grid').innerHTML = `
            <div class="stat-card">
                <div class="label">Total Stasiun</div>
                <div class="value">${chargingStations.length}</div>
            </div>
            <div class="stat-card green">
                <div class="label">Charger Tersedia</div>
                <div class="value">${chargerTersedia}/${totalCharger}</div>
            </div>
            <div class="stat-card orange">
                <div class="label">Keluhan Aktif</div>
                <div class="value">${keluhan.filter(k => k.status !== 'Selesai').length}</div>
            </div>
            <div class="stat-card red">
                <div class="label">Charger Bermasalah</div>
                <div class="value">${chargerError}</div>
            </div>
        `;

        function badgeClass(status) {
            return status.toLowerCase().replace(/\s+/g, '-');
        }

        // ===== RENDER CHARGING STATION =====
        const stationBody = document.querySelector('#station-table tbody');
        chargingStations.forEach(cs => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${cs.id_station}</td>
                <td>${cs.nama_st}</td>
                <td>${cs.alamat}</td>
                <td><span class="badge ${badgeClass(cs.status)}">${cs.status}</span></td>
            `;
            stationBody.appendChild(row);
        });
        document.getElementById('station-count').textContent = chargingStations.length + ' lokasi';

        // ===== RENDER CHARGER =====
        const chargerBody = document.querySelector('#charger-table tbody');
        chargers.forEach(c => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${c.kd_charger}</td>
                <td>${c.station}</td>
                <td>${c.konektor}</td>
                <td>${c.daya}</td>
                <td><span class="badge ${badgeClass(c.penggunaan)}">${c.penggunaan}</span></td>
                <td><span class="badge ${badgeClass(c.kondisi)}">${c.kondisi}</span></td>
            `;
            chargerBody.appendChild(row);
        });
        document.getElementById('charger-count').textContent = chargers.length + ' unit';

        // ===== RENDER TARIF =====
        const tarifBody = document.querySelector('#tarif-table tbody');
        tarifs.forEach(t => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${t.id_tarif}</td>
                <td>${t.station}</td>
                <td>Rp ${t.harga_per_kwh.toLocaleString('id-ID')}</td>
                <td>${t.berlaku_mulai}</td>
                <td><span class="badge ${badgeClass(t.status)}">${t.status}</span></td>
            `;
            tarifBody.appendChild(row);
        });
        document.getElementById('tarif-count').textContent = tarifs.length + ' tarif';

        // ===== RENDER KELUHAN =====
        const keluhanBody = document.querySelector('#keluhan-table tbody');
        if (keluhan.length === 0) {
            keluhanBody.innerHTML = `<tr><td colspan="5" class="empty-state">Belum ada keluhan</td></tr>`;
        } else {
            keluhan.forEach(k => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${k.tanggal}</td>
                    <td>${k.station}</td>
                    <td>${k.pengemudi}</td>
                    <td>${k.isi}</td>
                    <td><span class="badge ${badgeClass(k.status)}">${k.status}</span></td>
                `;
                keluhanBody.appendChild(row);
            });
        }
        document.getElementById('keluhan-count').textContent = keluhan.length + ' keluhan';
    </script>

</body>
</html>