@extends('layouts.admin')
@section('title', 'Dashboard')
@section('menu', 'dashboard')
@section('subtitle', 'Selamat datang di sistem administrasi EV ChargeHub.')

@section('content')
<div class="row g-3 mb-4" id="kartu"></div>

<div class="row g-4">
    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">User berdasarkan Role</div>
            <div class="card-body table-responsive" id="userPerRole"></div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Aktivitas Terbaru</div>
            <div class="card-body table-responsive" id="logTerbaru"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
boot(async () => {
    const d = await api('/ringkasan');

    const kartu = [
        ['Total User',         d.total_user,         'bi-people',       'text-primary'],
        ['User Aktif',         d.user_aktif,         'bi-person-check', 'text-success'],
        ['Total Role',         d.total_role,         'bi-shield-lock',  'text-warning'],
        ['Aktivitas Hari Ini', d.aktivitas_hari_ini, 'bi-activity',     'text-danger'],
    ];

    $('kartu').innerHTML = kartu.map(([judul, nilai, ikon, warna]) => `
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">${judul}</p>
                        <h3 class="fw-bold mb-0">${nilai ?? 0}</h3>
                    </div>
                    <div class="${warna} fs-2"><i class="bi ${ikon}"></i></div>
                </div>
            </div>
        </div>`).join('');

    $('userPerRole').innerHTML = tabel(['Role', 'Jumlah'],
        (d.user_per_role || []).map(r => [esc(r.role), r.total ?? 0]));

    $('logTerbaru').innerHTML = tabel(['User', 'Aktivitas', 'Waktu'],
        (d.log_terbaru || []).map(l => [esc(l.user?.identifier || '-'), esc(l.aktivitas), esc(l.waktu)]));
});
</script>
@endsection