@extends('layouts.admin')
@section('title', 'Laporan')
@section('menu', 'laporan')
@section('subtitle', 'Ringkasan aktivitas sistem per periode.')

@section('content')
<form id="laporanFilter" class="row g-2 mb-3">
    <div class="col-6 col-md-3">
        <label class="form-label small text-secondary mb-1">Dari</label>
        <input type="date" id="fDari" class="form-control">
    </div>
    <div class="col-6 col-md-3">
        <label class="form-label small text-secondary mb-1">Sampai</label>
        <input type="date" id="fSampai" class="form-control">
    </div>
    <div class="col-12 col-md-6 d-flex align-items-end gap-2">
        <button class="btn btn-success">Tampilkan</button>
        <button type="button" id="btnCsv" class="btn btn-outline-success">
            <i class="bi bi-download me-1"></i>Unduh CSV
        </button>
    </div>
</form>

<div class="row g-3 mb-4" id="kartuLaporan"></div>

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Aktivitas per Jenis</div>
            <div class="card-body table-responsive" id="perAktivitas"></div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">User Teraktif</div>
            <div class="card-body table-responsive" id="userTeraktif"></div>
        </div>
    </div>
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Aktivitas per Hari</div>
            <div class="card-body table-responsive" id="perHari"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
async function muatLaporan() {
    const p = new URLSearchParams();
    if ($('fDari').value)   p.set('dari', $('fDari').value);
    if ($('fSampai').value) p.set('sampai', $('fSampai').value);

    try {
        const d = await api('/laporan?' + p);

        $('fDari').value   = d.periode.dari;
        $('fSampai').value = d.periode.sampai;

        $('kartuLaporan').innerHTML = `
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100"><div class="card-body">
                    <p class="text-secondary mb-1">Total Aktivitas</p>
                    <h3 class="fw-bold mb-0">${d.total_aktivitas ?? 0}</h3>
                </div></div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card border-0 shadow-sm h-100"><div class="card-body">
                    <p class="text-secondary mb-1">Periode</p>
                    <h5 class="fw-bold mb-0">${esc(d.periode.dari)} s/d ${esc(d.periode.sampai)}</h5>
                </div></div>
            </div>`;

        $('perAktivitas').innerHTML = tabel(['Aktivitas', 'Jumlah'],
            (d.per_aktivitas || []).map(r => [esc(r.aktivitas), r.total]));

        $('userTeraktif').innerHTML = tabel(['User', 'Jumlah'],
            (d.user_teraktif || []).map(r => [esc(r.user?.identifier || r.id_user || '-'), r.total]));

        $('perHari').innerHTML = tabel(['Tanggal', 'Jumlah'],
            (d.per_hari || []).map(r => [esc(r.tanggal), r.total]));
    } catch (e) { alert(e.message); }
}

$('btnCsv').onclick = async () => {
    const p = new URLSearchParams({ dari: $('fDari').value, sampai: $('fSampai').value });
    try {
        const res = await fetch('/api/admin/laporan/csv?' + p, { headers: headers() });
        if (!res.ok) throw new Error('Gagal mengunduh laporan.');

        const url = URL.createObjectURL(await res.blob());
        const a = document.createElement('a');
        a.href = url;
        a.download = `laporan-${$('fDari').value}-${$('fSampai').value}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    } catch (e) { alert(e.message); }
};

$('laporanFilter').onsubmit = (e) => { e.preventDefault(); muatLaporan(); };

boot(muatLaporan);
</script>
@endsection