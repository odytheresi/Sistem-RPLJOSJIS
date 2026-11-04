@extends('layouts.admin')
@section('title', 'Audit log')
@section('menu', 'audit_log')
@section('subtitle', 'Riwayat aktivitas pengguna sistem.')

@section('content')
<form id="auditFilter" class="row g-2 mb-3">
    <div class="col-12 col-md-3"><input id="fUser" class="form-control" placeholder="User (identifier)"></div>
    <div class="col-6 col-md-3">
        <select id="fAktivitas" class="form-select">
            <option value="">Semua aktivitas</option>
            @foreach (['login', 'login_gagal', 'logout', 'ubah_role_user', 'ubah_hak_akses', 'ubah_status_role'] as $a)
                <option value="{{ $a }}">{{ $a }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-6 col-md-3"><input type="date" id="fTanggal" class="form-control" title="Tanggal"></div>
    <div class="col-6 col-md-3 d-flex gap-2">
        <button class="btn btn-success">Filter</button>
        <button type="button" id="fReset" class="btn btn-outline-secondary">Reset</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive" id="auditTable"></div>
</div>
@endsection

@section('scripts')
<script>
function muatAudit(page = 1) {
    const p = new URLSearchParams({ page });
    [['user', 'fUser'], ['aktivitas', 'fAktivitas'], ['tanggal', 'fTanggal']]
        .forEach(([k, id]) => $(id).value && p.set(k, $(id).value));

    return isi('auditTable', async () => {
        const r = await api('/audit-log?' + p);
        if (!r.data.length) return '<div class="text-secondary">Tidak ada log yang cocok.</div>';

        return tabel(['User', 'Aktivitas', 'Entitas', 'Keterangan', 'Waktu'], r.data.map(l => [
            esc(l.user?.identifier || l.id_user || '-'),
            esc(l.aktivitas),
            esc(l.entitas_terkait || '-'),
            esc(l.keterangan || '-'),
            esc(l.waktu),
        ])) + `
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-secondary">Halaman ${r.current_page} dari ${r.last_page}</small>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-secondary" ${r.current_page <= 1 ? 'disabled' : ''}
                        onclick="muatAudit(${r.current_page - 1})">Sebelumnya</button>
                <button class="btn btn-sm btn-outline-secondary" ${r.current_page >= r.last_page ? 'disabled' : ''}
                        onclick="muatAudit(${r.current_page + 1})">Berikutnya</button>
            </div>
        </div>`;
    });
}

$('auditFilter').onsubmit = (e) => { e.preventDefault(); muatAudit(1); };
$('fReset').onclick = () => { $('auditFilter').reset(); muatAudit(1); };

boot(() => muatAudit(1));
</script>
@endsection