@extends('layouts.operator')

@section('title', 'Dashboard')

@push('styles')
<style>
    .welcome-panel {
        padding: 28px;
        border-radius: 18px;
        background: linear-gradient(115deg, #1d4ed8, #477cf5);
        color: white;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .welcome-panel h3 {
        font-size: 23px;
        font-weight: 800;
        margin: 0 0 10px;
    }

    .welcome-panel p {
        color: #e0eaff;
        font-size: 13px;
        margin: 0;
        max-width: 520px;
        line-height: 1.8;
    }

    .welcome-tag {
        display: inline-block;
        margin-top: 20px;
        padding: 8px 12px;
        background: #ffffff20;
        border: 1px solid #ffffff45;
        border-radius: 9px;
        font-size: 12px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 800;
        margin: 0;
    }

    .section-subtitle {
        color: #8390a5;
        font-size: 12px;
        margin-top: 5px;
    }

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

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        font-size: 20px;
    }

    .blue { background: #e5edff; }
    .green { background: #dcfce7; }
    .orange { background: #ffedd5; }
    .red { background: #fee2e2; }

    .stat-label {
        font-size: 12px;
        color: #77849a;
        font-weight: 600;
        margin-top: 17px;
    }

    .stat-value {
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-top: 5px;
        color: #172033;
    }

    .stat-note {
        color: #98a2b3;
        font-size: 11px;
        margin-top: 5px;
    }

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
        border-color: #9bb7ff;
        box-shadow: 0 8px 22px #1d4ed80c;
        color: #1d4ed8;
    }

    .quick-icon {
        width: 43px;
        height: 43px;
        flex: 0 0 43px;
        display: grid;
        place-items: center;
        background: #edf2ff;
        border-radius: 12px;
        font-size: 20px;
    }

    .quick-link strong {
        display: block;
        font-size: 12px;
        font-weight: 800;
    }

    .quick-link small {
        display: block;
        margin-top: 5px;
        color: #8390a5;
        font-size: 10px;
    }

    .quick-arrow {
        margin-left: auto;
        color: #9ba6b8;
    }

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

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        white-space: nowrap;
    }

    .dashboard-table th {
        padding: 14px 18px;
        text-align: left;
        background: #f8fafc;
        color: #78869b;
        font-weight: 700;
        border-bottom: 1px solid #edf0f5;
    }

    .dashboard-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #f0f2f6;
        color: #475569;
    }

    .dashboard-table tbody tr:last-child td { border-bottom: 0; }
    .dashboard-table tbody tr:hover { background: #fafcff; }

    .empty-state {
        text-align: center;
        padding: 28px !important;
        color: #98a2b3 !important;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
    }

    .status-aktif, .status-tersedia, .status-normal, .status-selesai {
        background: #dcfce7;
        color: #166534;
    }

    .status-error, .status-nonaktif, .status-bermasalah {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-diproses, .status-digunakan {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-menunggu, .status-maintenance, .status-pending {
        background: #ffedd5;
        color: #9a3412;
    }

    .dashboard-footer {
        text-align: center;
        color: #98a2b3;
        font-size: 11px;
        padding: 10px;
    }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .quick-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 600px) {
        .stats-grid, .quick-grid { grid-template-columns: 1fr; }
        .welcome-panel { padding: 22px; }
        .welcome-panel h3 { font-size: 20px; }
    }
</style>
@endpush

@section('content')

<div class="welcome-panel">
    <h3>Selamat datang di EVChargeHub 👋</h3>
    <p>
        Kelola stasiun pengisian kendaraan listrik, pantau charger,
        atur tarif, dan tindak lanjuti keluhan melalui satu dashboard.
    </p>
    <span class="welcome-tag">⚡ Panel Manajemen Operator</span>
</div>

<div>
    <h3 class="section-title">Ringkasan Operasional</h3>
    <div class="section-subtitle">Ikhtisar data yang tercatat dalam sistem.</div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon blue">📍</div>
        </div>
        <div class="stat-label">Total Stasiun</div>
        <div class="stat-value">{{ $totalStation ?? 0 }}</div>
        <div class="stat-note">Stasiun terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon green">🔌</div>
        </div>
        <div class="stat-label">Total Charger</div>
        <div class="stat-value">{{ $totalCharger ?? 0 }}</div>
        <div class="stat-note">Unit charger terdaftar</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon orange">🛠️</div>
        </div>
        <div class="stat-label">Data Perawatan</div>
        <div class="stat-value">{{ $totalPerbaikan ?? 0 }}</div>
        <div class="stat-note">Catatan maintenance</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon red">📝</div>
        </div>
        <div class="stat-label">Total Keluhan</div>
        <div class="stat-value">{{ $totalKeluhan ?? 0 }}</div>
        <div class="stat-note">Keluhan tercatat</div>
    </div>
</div>

<div>
    <h3 class="section-title">Akses Cepat</h3>
    <div class="section-subtitle">Pilih menu untuk mengelola data operasional.</div>
</div>

<div class="quick-grid">
    <a class="quick-link" href="{{ route('operator.station.index') }}">
        <span class="quick-icon">📍</span>
        <span>
            <strong>Kelola Stasiun</strong>
            <small>Lihat dan atur lokasi stasiun</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>

    <a class="quick-link" href="{{ route('operator.charger.index') }}">
        <span class="quick-icon">🔌</span>
        <span>
            <strong>Kelola Charger</strong>
            <small>Lihat daftar unit charger</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>

    <a class="quick-link" href="{{ route('operator.charger.create') }}">
        <span class="quick-icon">➕</span>
        <span>
            <strong>Tambah Charger</strong>
            <small>Daftarkan unit charger baru</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>

    <a class="quick-link" href="{{ route('operator.tarif.index') }}">
        <span class="quick-icon">💰</span>
        <span>
            <strong>Atur Tarif</strong>
            <small>Lihat dan kelola tarif pengisian</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>

    <a class="quick-link" href="{{ route('operator.keluhan.index') }}">
        <span class="quick-icon">📝</span>
        <span>
            <strong>Kelola Keluhan</strong>
            <small>Periksa laporan pengguna</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>

    <a class="quick-link" href="{{ route('operator.perbaikan.index') }}">
        <span class="quick-icon">🛠️</span>
        <span>
            <strong>Maintenance</strong>
            <small>Lihat data perawatan</small>
        </span>
        <span class="quick-arrow">›</span>
    </a>
</div>

<section class="dashboard-panel">
    <div class="panel-header">
        <div>
            <h3 class="section-title">Lokasi Stasiun</h3>
            <div class="section-subtitle">Data stasiun yang terdaftar.</div>
        </div>
        <a class="btn btn-sm btn-outline-primary"
           href="{{ route('operator.station.index') }}">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="dashboard-table" id="station-table">
            <thead>
                <tr>
                    <th>ID Stasiun</th>
                    <th>Nama Stasiun</th>
                    <th>Alamat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="4" class="empty-state">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="dashboard-panel">
    <div class="panel-header">
        <div>
            <h3 class="section-title">Data Charger</h3>
            <div class="section-subtitle">Ringkasan unit charger terdaftar.</div>
        </div>
        <a class="btn btn-sm btn-outline-primary"
           href="{{ route('operator.charger.index') }}">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="dashboard-table" id="charger-table">
            <thead>
                <tr>
                    <th>Kode Charger</th>
                    <th>Nama Stasiun</th>
                    <th>Tipe Konektor</th>
                    <th>Daya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="5" class="empty-state">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="dashboard-panel">
    <div class="panel-header">
        <div>
            <h3 class="section-title">Informasi Tarif</h3>
            <div class="section-subtitle">Tarif pengisian yang tercatat.</div>
        </div>
        <a class="btn btn-sm btn-outline-primary"
           href="{{ route('operator.tarif.index') }}">Atur Tarif</a>
    </div>

    <div class="table-responsive">
        <table class="dashboard-table" id="tarif-table">
            <thead>
                <tr>
                    <th>ID Tarif</th>
                    <th>Nama Stasiun</th>
                    <th>Harga per kWh</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="4" class="empty-state">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</section>

<section class="dashboard-panel">
    <div class="panel-header">
        <div>
            <h3 class="section-title">Keluhan Terbaru</h3>
            <div class="section-subtitle">Laporan keluhan yang tercatat.</div>
        </div>
        <a class="btn btn-sm btn-outline-primary"
           href="{{ route('operator.keluhan.index') }}">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="dashboard-table" id="keluhan-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Stasiun</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="4" class="empty-state">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>
</section>

<div class="dashboard-footer">
    EVChargeHub · Panel Manajemen Operator
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stations = @json($chargingStations ?? []);
    const chargers = @json($chargers ?? []);
    const tarifs = @json($tarifs ?? []);
    const keluhan = @json($keluhan ?? []);

    function value(obj, keys, fallback = '-') {
        for (const key of keys) {
            const v = obj?.[key];
            if (v !== null && v !== undefined && v !== '') return v;
        }
        return fallback;
    }

    function safe(v) {
        return String(v ?? '-').replace(/[&<>"']/g, ch => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;',
            '"': '&quot;', "'": '&#39;'
        })[ch]);
    }

    function badge(v) {
        const text = String(v ?? 'Tidak diketahui');
        const key = text.toLowerCase().replace(/[_\s]+/g, '-');
        const known = [
            'aktif', 'tersedia', 'normal', 'selesai',
            'error', 'nonaktif', 'bermasalah',
            'diproses', 'digunakan', 'menunggu', 'pending', 'maintenance'
        ];
        const cls = known.includes(key) ? 'status-' + key : '';
        return '<span class="status-badge ' + cls + '">' + safe(text) + '</span>';
    }

    function stationName(obj) {
        return value(obj?.charging_station,
            ['nama_stasiun', 'nama_station', 'nama_st', 'nama_lokasi'],
            value(obj, ['nama_stasiun', 'nama_station', 'nama_st', 'nama_lokasi'],
                value(obj?.charger?.charging_station,
                    ['nama_stasiun', 'nama_station', 'nama_st'], '-'));
    }

    function render(id, data, columns) {
        const tbody = document.querySelector('#' + id + ' tbody');
        if (!tbody) return;

        if (!Array.isArray(data) || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="' + columns.length +
                '" class="empty-state">Belum ada data untuk ditampilkan.</td></tr>';
            return;
        }

        tbody.innerHTML = data.slice(0, 5).map(item =>
            '<tr>' + columns.map(col => {
                const v = col.get(item);
                return '<td>' + (col.badge ? badge(v) : safe(v)) + '</td>';
            }).join('') + '</tr>'
        ).join('');
    }

    render('station-table', stations, [
        { get: x => value(x, ['id_stasiun', 'id_station', 'id']) },
        { get: x => value(x, ['nama_stasiun', 'nama_station', 'nama_st', 'nama_lokasi', 'nama']) },
        { get: x => value(x, ['alamat', 'alamat_stasiun', 'lokasi']) },
        { get: x => value(x, ['status', 'status_stasiun']), badge: true }
    ]);

    render('charger-table', chargers, [
        { get: x => value(x, ['kode_charger', 'id_charger', 'kode', 'id']) },
        { get: x => stationName(x) },
        { get: x => value(x, ['tipe_konektor', 'jenis_konektor', 'konektor']) },
        { get: x => {
            const d = value(x, ['daya_kw', 'daya', 'kapasitas_daya', 'power']);
            return d === '-' ? d : d + ' kW';
        }},
        { get: x => value(x, ['status', 'status_charger']), badge: true }
    ]);

    render('tarif-table', tarifs, [
        { get: x => value(x, ['id_tarif', 'id']) },
        { get: x => stationName(x) },
        { get: x => {
            const h = value(x, ['harga_per_kwh', 'tarif_per_kwh', 'harga', 'nominal']);
            return h === '-' ? h : 'Rp ' + Number(h).toLocaleString('id-ID');
        }},
        { get: x => value(x, ['status', 'status_tarif']), badge: true }
    ]);

    render('keluhan-table', keluhan, [
        { get: x => value(x, ['tanggal_keluhan', 'tanggal', 'created_at']) },
        { get: x => stationName(x) },
        { get: x => value(x, ['deskripsi', 'isi_keluhan', 'keterangan', 'keluhan']) },
        { get: x => value(x, ['status', 'status_keluhan']), badge: true }
    ]);
});
</script>
@endpush
