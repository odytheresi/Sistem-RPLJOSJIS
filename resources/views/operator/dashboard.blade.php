<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Operator - EVChargeHub</title>
<style>
    :root {
        --green: #3d9e71; --green-dark: #2f7d59; --green-soft: #e0f1e8;
        --text: #172033; --muted: #8390a5; --line: #e7ecf3;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; color: var(--text);
        display: flex; min-height: 100vh; font-size: 14px;
    }
    a { color: var(--green); text-decoration: none; }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 240px; background: linear-gradient(180deg, #3d9e71, #2a7352);
        color: #fff; padding: 24px 16px; flex-shrink: 0;
    }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a {
        display: block; color: #e6f5ed; padding: 12px 14px; border-radius: 10px; margin-bottom: 10px;
        font-size: 14px; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
        transition: background .2s, transform .2s;
    }
    .sidebar nav a:hover { background: rgba(255,255,255,.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active { background: rgba(255,255,255,.28); border-color: rgba(255,255,255,.5); color: #fff; font-weight: 700; }

    /* ===== MAIN ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
    .topbar h2 { font-size: 22px; font-weight: 800; }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .operator-badge {
        display: flex; align-items: center; gap: 10px; background: #fff; padding: 8px 14px;
        border-radius: 999px; border: 1px solid var(--line); box-shadow: 0 4px 16px #16274805;
    }
    .operator-badge .avatar {
        width: 32px; height: 32px; border-radius: 50%; background: var(--green); color: #fff;
        display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 13px;
    }
    .operator-badge small { color: var(--muted); display: block; font-size: 11px; }
    .operator-badge strong { font-size: 13px; }
    .operator-badge { cursor: pointer; font-family: inherit; text-align: left; color: var(--text); }
    .operator-badge:hover { border-color: #a6d8bf; }
    .operator-badge .caret { color: var(--muted); font-size: 11px; margin-left: 2px; transition: transform .2s; }
    .profile.open .caret { transform: rotate(180deg); }
    .profile { position: relative; }

    /* ===== LOGOUT ===== */
    .sidebar { display: flex; flex-direction: column; }
    .sidebar-logout { margin-top: auto; padding-top: 16px; }
    .sidebar-logout form { margin: 0; }
    .btn-logout-side {
        width: 100%; padding: 12px 14px; border-radius: 10px; font-size: 14px; font-family: inherit; cursor: pointer;
        color: #fff; background: rgba(220,38,38,.35); border: 1px solid rgba(255,255,255,.3); text-align: left; transition: .2s;
    }
    .btn-logout-side:hover { background: #dc2626; transform: translateX(3px); }
    .profile-logout { margin: 12px 0 0; padding-top: 12px; border-top: 1px solid #edf0f5; }
    .btn-logout-card {
        width: 100%; padding: 9px 12px; border-radius: 9px; font-size: 12px; font-weight: 700; font-family: inherit;
        cursor: pointer; background: #fff; color: #dc2626; border: 1px solid #fecaca; transition: .2s;
    }
    .btn-logout-card:hover { background: #dc2626; color: #fff; }
    .profile-card {
        position: absolute; right: 0; top: calc(100% + 10px); width: 300px; z-index: 50;
        background: #fff; border: 1px solid var(--line); border-radius: 15px; padding: 18px;
        box-shadow: 0 12px 30px rgba(22,39,72,.15); display: none;
    }
    .profile.open .profile-card { display: block; }
    .profile-top { display: flex; align-items: center; gap: 12px; padding-bottom: 14px; border-bottom: 1px solid #edf0f5; margin-bottom: 12px; }
    .profile-top .avatar-lg {
        width: 46px; height: 46px; border-radius: 50%; background: var(--green); color: #fff;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; flex-shrink: 0;
    }
    .profile-top strong { display: block; font-size: 14px; }
    .profile-top span { font-size: 11px; color: var(--green-dark); background: var(--green-soft); padding: 2px 8px; border-radius: 10px; font-weight: 700; display: inline-block; margin-top: 4px; }
    .profile-row { display: flex; justify-content: space-between; gap: 12px; padding: 8px 0; font-size: 12px; }
    .profile-row dt { color: var(--muted); }
    .profile-row dd { margin: 0; font-weight: 700; text-align: right; word-break: break-all; }
    @media (max-width: 600px) { .profile-card { right: auto; left: 0; width: 280px; } }

    /* ===== PERHATIAN ===== */
    .alerts { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; }
    .alert-chip {
        display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: 10px;
        font-size: 12px; font-weight: 600; cursor: pointer; border: 1px solid transparent;
    }
    .alert-chip.orange { background: #ffedd5; color: #9a3412; }
    .alert-chip.red { background: #fee2e2; color: #b91c1c; }
    .alert-chip.green { background: #dcfce7; color: #166534; cursor: default; }

    /* ===== STAT CARDS ===== */
    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 22px; }
    .stat-card {
        background: #fff; border: 1px solid var(--line); border-radius: 15px; padding: 18px 20px;
        box-shadow: 0 4px 16px #16274805; display: flex; gap: 14px; align-items: flex-start; min-width: 0;
    }
    .stat-icon { width: 42px; height: 42px; flex: 0 0 42px; display: grid; place-items: center; border-radius: 12px; font-size: 19px; }
    .bg-green { background: var(--green-soft); }
    .bg-lime { background: #dcfce7; }
    .bg-orange { background: #ffedd5; }
    .bg-red { background: #fee2e2; }
    .stat-body { min-width: 0; flex: 1; }
    .stat-label { font-size: 11px; color: #77849a; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
    .stat-value { font-size: 26px; font-weight: 800; letter-spacing: -1px; margin-top: 2px; }
    .stat-value small { font-size: 13px; color: var(--muted); font-weight: 600; letter-spacing: 0; }
    .stat-note { color: #98a2b3; font-size: 11px; margin-top: 3px; }
    .stat-split { display: flex; gap: 14px; margin-top: 2px; }
    .stat-split div { font-size: 11px; color: #77849a; }
    .stat-split b { display: block; font-size: 22px; font-weight: 800; color: var(--text); letter-spacing: -1px; }
    .bar { height: 6px; border-radius: 6px; background: #edf0f5; margin-top: 9px; overflow: hidden; display: flex; }
    .bar span { display: block; height: 100%; }

    /* ===== PANEL DATA (tab) ===== */
    .dashboard-panel { background: #fff; border: 1px solid var(--line); border-radius: 15px; overflow: hidden; margin-bottom: 22px; }
    .panel-head { padding: 16px 20px 0; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; }
    .section-title { font-size: 16px; font-weight: 800; }
    .section-subtitle { color: var(--muted); font-size: 12px; margin-top: 4px; }
    .tabs { display: flex; gap: 4px; padding: 14px 20px 0; border-bottom: 1px solid #edf0f5; overflow-x: auto; }
    .tab {
        padding: 10px 14px; font-size: 12px; font-weight: 700; color: #78869b; background: none; border: 0;
        border-bottom: 2px solid transparent; cursor: pointer; white-space: nowrap; font-family: inherit;
    }
    .tab:hover { color: var(--text); }
    .tab.active { color: var(--green-dark); border-bottom-color: var(--green); }
    .tab .n {
        display: inline-block; min-width: 20px; padding: 1px 6px; margin-left: 5px; border-radius: 10px;
        background: #f1f5f9; color: #64748b; font-size: 10px; text-align: center;
    }
    .tab.active .n { background: var(--green-soft); color: var(--green-dark); }
    .toolbar { display: flex; gap: 10px; align-items: center; justify-content: space-between; flex-wrap: wrap; padding: 14px 20px; }
    .toolbar input {
        flex: 1; min-width: 200px; max-width: 340px; padding: 9px 13px; border: 1px solid var(--line); border-radius: 10px;
        font-size: 12px; font-family: inherit; outline: none; background: #fff; color: var(--text);
    }
    .toolbar input:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .toolbar .meta { display: flex; align-items: center; gap: 12px; font-size: 11px; color: var(--muted); }
    .btn {
        display: inline-block; padding: 7px 12px; border-radius: 9px; font-size: 11px; font-weight: 700;
        background: var(--green); color: #fff; border: 0; cursor: pointer; font-family: inherit; transition: .2s;
    }
    .btn:hover { background: var(--green-dark); color: #fff; }

    .table-responsive { overflow: auto; max-height: 400px; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap; }
    th {
        padding: 12px 18px; text-align: left; background: #f8fafc; color: #78869b; font-weight: 700;
        border-bottom: 1px solid #edf0f5; position: sticky; top: 0; z-index: 1;
    }
    td { padding: 13px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; }
    td strong { color: var(--text); }
    td .sub { display: block; color: #98a2b3; font-size: 10px; margin-top: 2px; }
    td.wrap { white-space: normal; min-width: 220px; max-width: 360px; }
    tbody tr { cursor: pointer; transition: background .15s; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    .empty-state { text-align: center; padding: 30px !important; color: #98a2b3 !important; cursor: default; }
    tr.no-hover { cursor: default; }

    /* ===== BADGE ===== */
    .badge { display: inline-block; padding: 4px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; background: #f1f5f9; color: #64748b; text-transform: capitalize; }
    .badge.aktif, .badge.normal, .badge.tersedia, .badge.selesai { background: #dcfce7; color: #166534; }
    .badge.error, .badge.rusak, .badge.nonaktif, .badge.ditolak { background: #fee2e2; color: #b91c1c; }
    .badge.digunakan, .badge.penuh, .badge.diproses { background: #dbeafe; color: #1d4ed8; }
    .badge.maintenance, .badge.perbaikan, .badge.dalam-perawatan, .badge.pending, .badge.baru { background: #ffedd5; color: #9a3412; }

    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15,23,42,.5); display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: all .2s ease; z-index: 999; padding: 16px;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-box {
        background: #fff; width: 100%; max-width: 440px; border-radius: 15px; padding: 22px;
        border: 1px solid var(--line); box-shadow: 0 10px 25px rgba(0,0,0,.1);
        transform: translateY(10px); transition: transform .2s ease; max-height: 90vh; overflow-y: auto;
    }
    .modal-overlay.active .modal-box { transform: translateY(0); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #edf0f5; padding-bottom: 10px; }
    .modal-header h3 { font-size: 16px; font-weight: 800; }
    .modal-close { background: #f1f5f9; border: 0; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; color: #64748b; font-size: 16px; }
    .modal-body { display: grid; grid-template-columns: 130px 1fr; row-gap: 11px; font-size: 13px; }
    .modal-body dt { color: var(--muted); font-size: 12px; }
    .modal-body dd { margin: 0; font-weight: 600; color: var(--text); word-break: break-word; }
    .modal-footer { margin-top: 18px; display: flex; justify-content: flex-end; gap: 8px; }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 900px) { body { flex-direction: column; } .sidebar { width: 100%; } .main { padding: 22px 18px; } }
    @media (max-width: 600px) { .stats-grid { grid-template-columns: 1fr; } .modal-body { grid-template-columns: 1fr; row-gap: 2px; } .modal-body dd { margin-bottom: 9px; } }
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

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar?')">
                @csrf
                <button type="submit" class="btn-logout-side">🚪 Keluar</button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN ===== -->
    <main class="main">

        <div class="topbar">
            <div>
                <h2>Dashboard Operator</h2>
                <p id="today">Ringkasan operasional stasiun dan charger.</p>
            </div>
            <div class="profile" id="profile">
                <button type="button" class="operator-badge" id="profileBtn" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar" id="avatar-initial">-</div>
                    <div>
                        <strong id="operator-name">Memuat...</strong>
                        <small id="operator-id">-</small>
                    </div>
                    <span class="caret">▾</span>
                </button>
                <div class="profile-card" id="profileCard">
                    <div class="profile-top">
                        <div class="avatar-lg" id="pAvatar">-</div>
                        <div>
                            <strong id="pNama">-</strong>
                            <span>Operator</span>
                        </div>
                    </div>
                    <dl>
                        <div class="profile-row"><dt>ID Operator</dt><dd id="pId">-</dd></div>
                        <div class="profile-row"><dt>Email</dt><dd id="pEmail">-</dd></div>
                        <div class="profile-row"><dt>No. HP</dt><dd id="pHp">-</dd></div>
                        <div class="profile-row"><dt>Terdaftar</dt><dd id="pSejak">-</dd></div>
                        <div class="profile-row"><dt>Stasiun dikelola</dt><dd id="pStasiun">-</dd></div>
                    </dl>
                    <form method="POST" action="{{ route('logout') }}" class="profile-logout" onsubmit="return confirm('Yakin ingin keluar?')">
                        @csrf
                        <button type="submit" class="btn-logout-card">🚪 Keluar dari akun</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== PERLU PERHATIAN ===== -->
        <div class="alerts" id="alerts"></div>

        <!-- ===== STATISTIK ===== -->
        <div class="stats-grid" id="stats-grid"></div>

        <!-- ===== DATA OPERASIONAL (TAB) ===== -->
        <section class="dashboard-panel">
            <div class="panel-head">
                <div>
                    <h3 class="section-title">Data Operasional</h3>
                    <div class="section-subtitle">Klik baris untuk melihat detail lengkap.</div>
                </div>
            </div>
            <div class="tabs" id="tabs"></div>
            <div class="toolbar">
                <input type="text" id="q" placeholder="🔍 Cari di tab ini...">
                <div class="meta">
                    <span id="rowCount">-</span>
                    <a class="btn" id="manageLink" href="#">Kelola →</a>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead id="thead"></thead>
                    <tbody id="tbody"></tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- ===== MODAL DETAIL ===== -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalTitle">Detail Data</h3>
                <button type="button" class="modal-close" onclick="closeModal()">×</button>
            </div>
            <dl class="modal-body" id="modalContent"></dl>
            <div class="modal-footer">
                <a class="btn" id="modalLink" href="#">Kelola data →</a>
                <button type="button" class="btn" style="background:#64748b" onclick="closeModal()">Tutup</button>
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

        const totalStationCount = {{ (int) $totalStation }};
        const totalChargerCount = {{ (int) $totalCharger }};
        const chargerAktifCount = {{ (int) $chargerAktif }};
        const chargerNonaktifCount = {{ (int) $chargerNonaktif }};
        const chargerMaintenanceCount = {{ (int) $chargerMaintenance }};

        // ===== HELPER =====
        const $ = id => document.getElementById(id);
        const esc = s => String(s ?? '-').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        const badgeClass = s => s ? String(s).toLowerCase().replace(/\s+/g, '-') : '';
        const badge = s => '<span class="badge ' + esc(badgeClass(s)) + '">' + esc(s) + '</span>';
        const rupiah = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
        function fmtDate(v) {
            if (!v) return '-';
            const d = new Date(v);
            return isNaN(d) ? String(v) : d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        // ===== IDENTITAS OPERATOR & TANGGAL =====
        const namaOperator = operator.nama ?? operator.nama_operator ?? 'Operator';
        const inisial = String(namaOperator).charAt(0).toUpperCase();
        $('operator-name').textContent = namaOperator;
        $('operator-id').textContent = 'ID Operator #' + operator.id_operator;
        $('avatar-initial').textContent = inisial;

        // Kartu profil (kolom yang tidak dikirim controller ditampilkan "-")
        $('pAvatar').textContent = inisial;
        $('pNama').textContent = namaOperator;
        $('pId').textContent = '#' + operator.id_operator;
        $('pEmail').textContent = operator.email || '-';
        $('pHp').textContent = operator.no_hp || '-';
        $('pSejak').textContent = operator.terdaftar || (operator.created_at ? new Date(operator.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-');
        $('pStasiun').textContent = totalStationCount + ' lokasi';

        // Buka/tutup kartu profil
        const profile = $('profile');
        $('profileBtn').addEventListener('click', function (e) {
            e.stopPropagation();
            const open = profile.classList.toggle('open');
            this.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function (e) { if (!profile.contains(e.target)) profile.classList.remove('open'); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') profile.classList.remove('open'); });
        $('today').textContent = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

        // ===== DATA TURUNAN =====
        const isPending = k => !k.status || /pending|baru|menunggu/i.test(k.status);
        const keluhanBaru = keluhan.filter(isPending).length;
        const persenAktif = totalChargerCount ? Math.round(chargerAktifCount / totalChargerCount * 100) : 0;
        const pct = n => totalChargerCount ? (n / totalChargerCount * 100) : 0;

        // jumlah charger per stasiun (berdasar nama stasiun)
        const chargerPerStasiun = {};
        chargers.forEach(c => {
            const n = c.charging_station ? c.charging_station.nama_st : null;
            if (n) chargerPerStasiun[n] = (chargerPerStasiun[n] || 0) + 1;
        });

        // ===== STATISTIK =====
        $('stats-grid').innerHTML = `
            <div class="stat-card">
                <div class="stat-icon bg-green">📍</div>
                <div class="stat-body">
                    <div class="stat-label">Total Stasiun</div>
                    <div class="stat-value">${totalStationCount}</div>
                    <div class="stat-note">${totalChargerCount} unit charger terpasang</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-lime">🔌</div>
                <div class="stat-body">
                    <div class="stat-label">Charger Aktif</div>
                    <div class="stat-value">${chargerAktifCount}<small> / ${totalChargerCount}</small></div>
                    <div class="bar" title="${persenAktif}% aktif">
                        <span style="width:${pct(chargerAktifCount)}%;background:#3d9e71"></span>
                        <span style="width:${pct(chargerMaintenanceCount)}%;background:#f59e0b"></span>
                        <span style="width:${pct(chargerNonaktifCount)}%;background:#dc2626"></span>
                    </div>
                    <div class="stat-note">${persenAktif}% unit beroperasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-orange">🛠️</div>
                <div class="stat-body">
                    <div class="stat-label">Perlu Tindakan</div>
                    <div class="stat-split">
                        <div><b>${chargerMaintenanceCount}</b>Perawatan</div>
                        <div><b>${chargerNonaktifCount}</b>Non-aktif</div>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-red">📝</div>
                <div class="stat-body">
                    <div class="stat-label">Keluhan Baru</div>
                    <div class="stat-value">${keluhanBaru}</div>
                    <div class="stat-note">dari ${keluhan.length} total keluhan</div>
                </div>
            </div>`;

        // ===== PERINGATAN RINGKAS =====
        (function () {
            const a = [];
            if (keluhanBaru > 0) a.push(['red', '📝 ' + keluhanBaru + ' keluhan menunggu ditindaklanjuti', 'keluhan']);
            if (chargerNonaktifCount > 0) a.push(['red', '⛔ ' + chargerNonaktifCount + ' charger non-aktif', 'charger']);
            if (chargerMaintenanceCount > 0) a.push(['orange', '🛠️ ' + chargerMaintenanceCount + ' charger dalam perawatan', 'charger']);
            $('alerts').innerHTML = a.length
                ? a.map(x => '<span class="alert-chip ' + x[0] + '" onclick="setTab(\'' + x[2] + '\')">' + x[1] + '</span>').join('')
                : '<span class="alert-chip green">✅ Semua operasional normal, tidak ada yang perlu ditindaklanjuti.</span>';
        })();

        // ===== KONFIGURASI TAB =====
        const stationOf = c => c.charging_station ? c.charging_station.nama_st : '-';
        const TABS = {
            stasiun: {
                label: 'Stasiun', title: 'Charging Station', link: '/operator/lokasi_stasiun', data: chargingStations,
                head: ['Nama Stasiun', 'Alamat', 'Charger', 'Status'],
                cells: cs => ['<strong>' + esc(cs.nama_st) + '</strong><span class="sub">ID ' + esc(cs.id) + '</span>',
                              '<td class="wrap">' + esc(cs.alamat), (chargerPerStasiun[cs.nama_st] || 0) + ' unit', badge(cs.status)],
                search: cs => [cs.nama_st, cs.alamat, cs.status].join(' '),
                detail: cs => ({ 'ID': cs.id, 'Nama Stasiun': cs.nama_st, 'Alamat': cs.alamat, 'Jumlah Charger': (chargerPerStasiun[cs.nama_st] || 0) + ' unit', 'Status': cs.status })
            },
            charger: {
                label: 'Charger', title: 'Unit Charger', link: '/operator/charger', data: chargers,
                head: ['Kode', 'Stasiun', 'Konektor', 'Daya', 'Status'],
                cells: c => ['<strong>' + esc(c.kd_charger) + '</strong>', esc(stationOf(c)),
                             esc(c.tipe_konektor ? c.tipe_konektor.nm_konektor : '-'), esc(c.daya_maks ?? c.daya) + ' kW', badge(c.status ?? 'Tersedia')],
                search: c => [c.kd_charger, stationOf(c), c.tipe_konektor ? c.tipe_konektor.nm_konektor : '', c.status].join(' '),
                detail: c => ({ 'Kode Charger': c.kd_charger, 'Stasiun': stationOf(c), 'Konektor': c.tipe_konektor ? c.tipe_konektor.nm_konektor : '-',
                                'Daya Maks': (c.daya_maks ?? c.daya) + ' kW', 'Status': c.status ?? 'Tersedia' })
            },
            tarif: {
                label: 'Tarif', title: 'Tarif', link: '/operator/tarif', data: tarifs,
                head: ['Stasiun', 'Charger', 'Harga / kWh', 'Berlaku Mulai'],
                cells: t => [esc(t.charger && t.charger.charging_station ? t.charger.charging_station.nama_st : '-'),
                             esc(t.charger ? t.charger.kd_charger : '-'),
                             '<strong>' + rupiah(t.harga_per_kWh ?? t.harga_per_kwh) + '</strong>', esc(fmtDate(t.berlaku_mulai))],
                search: t => [t.charger && t.charger.charging_station ? t.charger.charging_station.nama_st : '', t.charger ? t.charger.kd_charger : '', t.harga_per_kWh ?? t.harga_per_kwh].join(' '),
                detail: t => ({ 'ID Tarif': t.id, 'Stasiun': t.charger && t.charger.charging_station ? t.charger.charging_station.nama_st : '-',
                                'Charger': t.charger ? t.charger.kd_charger : '-', 'Harga / kWh': rupiah(t.harga_per_kWh ?? t.harga_per_kwh),
                                'Berlaku Mulai': fmtDate(t.berlaku_mulai) })
            },
            keluhan: {
                label: 'Keluhan', title: 'Keluhan Pengguna', link: '/operator/keluhan', data: keluhan,
                head: ['Tanggal', 'Stasiun', 'Pengemudi', 'Keluhan', 'Status'],
                cells: k => [esc(fmtDate(k.tanggal)), esc(k.stasiun), esc(k.pengemudi), '<td class="wrap">' + esc(k.keluhan), badge(k.status ?? 'Pending')],
                search: k => [k.tanggal, k.stasiun, k.pengemudi, k.keluhan, k.status].join(' '),
                detail: k => ({ 'Tanggal': fmtDate(k.tanggal), 'Stasiun': k.stasiun, 'Pengemudi': k.pengemudi, 'Keluhan': k.keluhan, 'Status': k.status ?? 'Pending' })
            }
        };
        let activeTab = 'stasiun';

        function renderTabs() {
            $('tabs').innerHTML = Object.keys(TABS).map(k =>
                '<button type="button" class="tab' + (k === activeTab ? ' active' : '') + '" onclick="setTab(\'' + k + '\')">' +
                TABS[k].label + '<span class="n">' + TABS[k].data.length + '</span></button>').join('');
        }

        function renderTable() {
            const t = TABS[activeTab];
            const q = $('q').value.trim().toLowerCase();
            const rows = t.data.filter(d => !q || t.search(d).toLowerCase().includes(q));

            $('thead').innerHTML = '<tr>' + t.head.map(h => '<th>' + h + '</th>').join('') + '</tr>';
            const body = $('tbody');
            body.innerHTML = '';

            if (!rows.length) {
                body.innerHTML = '<tr class="no-hover"><td colspan="' + t.head.length + '" class="empty-state">' +
                    (q ? 'Tidak ada hasil untuk "' + esc(q) + '"' : 'Belum ada data') + '</td></tr>';
            } else {
                rows.forEach(d => {
                    const tr = document.createElement('tr');
                    // sel yang diawali "<td class=" sudah berisi tag td sendiri (untuk teks panjang)
                    tr.innerHTML = t.cells(d).map(c => c.startsWith('<td') ? c + '</td>' : '<td>' + c + '</td>').join('');
                    tr.addEventListener('click', () => openModal(t, d));
                    body.appendChild(tr);
                });
            }
            $('rowCount').textContent = rows.length === t.data.length ? t.data.length + ' data' : rows.length + ' dari ' + t.data.length + ' data';
            $('manageLink').href = t.link;
        }

        function setTab(k) {
            activeTab = k;
            $('q').value = '';
            renderTabs();
            renderTable();
            if (event && event.target && event.target.classList.contains('alert-chip')) {
                document.querySelector('.tabs').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        $('q').addEventListener('input', renderTable);

        // ===== MODAL =====
        function openModal(tab, d) {
            $('modalTitle').textContent = tab.title;
            $('modalLink').href = tab.link;
            $('modalContent').innerHTML = Object.entries(tab.detail(d))
                .map(([k, v]) => '<dt>' + esc(k) + '</dt><dd>' + esc(v) + '</dd>').join('');
            $('detailModal').classList.add('active');
        }
        function closeModal() { $('detailModal').classList.remove('active'); }
        $('detailModal').addEventListener('click', e => { if (e.target.id === 'detailModal') closeModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        renderTabs();
        renderTable();
    </script>

</body>
</html>