@extends('layouts.admin')
@section('title', 'Dashboard')
@section('menu', 'dashboard')
@section('subtitle', 'Selamat datang di sistem administrasi EV ChargeHub.')

@section('styles')
<style>
    .stat-card .label { font-size: 12px; color: #77849a; font-weight: 600; }
    .stat-card .value { font-size: 28px; font-weight: 800; letter-spacing: -1px; line-height: 1.1; }
    .stat-card.hl { background: linear-gradient(135deg, #3d9e71, #2a7352); border: 0 !important; color: #fff; }
    .stat-card.hl .label { color: #d4eee1; }
    .stat-card.hl .stat-icon { background: rgba(255,255,255,.22); color: #fff; }

    .donut {
        width: 170px; height: 170px; border-radius: 50%; margin: 0 auto;
        display: grid; place-items: center; position: relative;
    }
    .donut::after {
        content: ''; position: absolute; inset: 26px; background: #fff; border-radius: 50%;
    }
    .donut-center { position: absolute; z-index: 1; text-align: center; }
    .donut-center b { display: block; font-size: 26px; font-weight: 800; line-height: 1; }
    .donut-center small { color: #8390a5; font-size: 11px; }

    .legend-row { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f2f6; font-size: 13px; }
    .legend-row:last-child { border-bottom: 0; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 8px; }

    .ops-row { display: flex; align-items: center; gap: 12px; padding: 14px 0; border-bottom: 1px solid #f0f2f6; }
    .ops-row:last-child { border-bottom: 0; }
    .ops-row .ops-label { font-size: 12px; color: #77849a; font-weight: 600; }
    .ops-row .ops-value { font-size: 20px; font-weight: 800; letter-spacing: -.5px; }
</style>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <!-- Kiri: 4 kartu utama (2x2) -->
    <div class="col-12 col-xl-8">
        <div class="row g-4" id="kartuUtama"></div>
    </div>

    <!-- Kanan: donut role -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header fw-bold">User berdasarkan Role</div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="donut mb-3" id="donut">
                    <div class="donut-center"><b id="donutTotal">0</b><small>Total user</small></div>
                </div>
                <div id="legendRole"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Kiri: aktivitas terbaru -->
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header fw-bold">Aktivitas Terbaru</div>
            <div class="card-body table-responsive" id="logTerbaru"></div>
        </div>
    </div>

    <!-- Kanan: ringkasan operasional -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header fw-bold">Ringkasan Operasional</div>
            <div class="card-body py-2" id="ringkasanOps"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const rp = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
const WARNA = ['#3d9e71', '#E1932C', '#133968', '#A0CED9', '#dc2626', '#8b5cf6'];

boot(async () => {
    const d = await api('/ringkasan');

    // ---------- 4 kartu utama ----------
    const utama = [
        ['Total User',         d.total_user,         'bi-people',       'ic-navy',   false],
        ['User Aktif',         d.user_aktif,         'bi-person-check', 'ic-green',  false],
        ['Total Role',         d.total_role,         'bi-shield-lock',  'ic-orange', false],
        ['Aktivitas Hari Ini', d.aktivitas_hari_ini, 'bi-activity',     'ic-red',    false],
    ];

    $('kartuUtama').innerHTML = utama.map(([judul, nilai, ikon, ic, hl]) => `
        <div class="col-12 col-sm-6">
            <div class="card stat-card h-100 ${hl ? 'hl' : ''}">
                <div class="card-body d-flex align-items-start gap-3">
                    <div class="stat-icon ${ic}"><i class="bi ${ikon}"></i></div>
                    <div>
                        <div class="label">${judul}</div>
                        <div class="value">${nilai ?? 0}</div>
                    </div>
                </div>
            </div>
        </div>`).join('');

    // ---------- Donut role ----------
    const roles = d.user_per_role || [];
    const total = roles.reduce((a, r) => a + Number(r.total || 0), 0);

    let mulai = 0;
    const potongan = roles.map((r, i) => {
        const persen = total ? (Number(r.total) / total) * 100 : 0;
        const s = `${WARNA[i % WARNA.length]} ${mulai}% ${mulai + persen}%`;
        mulai += persen;
        return s;
    });
    $('donut').style.background = total
        ? `conic-gradient(${potongan.join(', ')})`
        : '#edf0f5';
    $('donutTotal').textContent = total;

    $('legendRole').innerHTML = roles.map((r, i) => `
        <div class="legend-row">
            <span><span class="legend-dot" style="background:${WARNA[i % WARNA.length]}"></span>${esc(r.role)}</span>
            <b>${r.total ?? 0}</b>
        </div>`).join('') || '<div class="text-secondary small text-center">Belum ada data.</div>';

    // ---------- Ringkasan operasional ----------
    const ops = [
        ['Sesi Charging Hari Ini', d.sesi_hari_ini ?? 0,         'bi-ev-station',          'ic-green'],
        ['Pendapatan Bulan Ini',   rp(d.pendapatan_bulan_ini),   'bi-cash-stack',          'ic-lime'],
        ['Menunggu Perbaikan',     d.gangguan_aktif ?? 0,        'bi-exclamation-triangle','ic-orange'],
    ];

    $('ringkasanOps').innerHTML = ops.map(([judul, nilai, ikon, ic]) => `
        <div class="ops-row">
            <div class="stat-icon ${ic}"><i class="bi ${ikon}"></i></div>
            <div>
                <div class="ops-label">${judul}</div>
                <div class="ops-value">${nilai}</div>
            </div>
        </div>`).join('');

    // ---------- Aktivitas terbaru ----------
    $('logTerbaru').innerHTML = tabel(['User', 'Aktivitas', 'Waktu'],
        (d.log_terbaru || []).map(l => [esc(l.user?.identifier || '-'), esc(l.aktivitas), esc(l.waktu)]));
});
</script>
@endsection