@extends('layouts.admin')
@section('title', 'Hak Akses')
@section('menu', 'role_hak_akses')
@section('subtitle', 'Kelola hak akses fitur per role.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive" id="roleTable"></div>
</div>

<div class="modal fade" id="modalAkses" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAksesTitle">Hak akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body table-responsive" id="aksesBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btnSimpanAkses">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let roles = [], roleAktif = null;
const AKSI = ['lihat', 'tambah', 'ubah', 'hapus'];

function muatRole() {
    return isi('roleTable', async () => {
        roles = list(await api('/role'));
        const ubah = can('role_hak_akses', 'ubah');

        return tabel(['ID Role', 'Nama Role', 'Status', ...(ubah ? ['Aksi'] : [])],
            roles.map(r => [
                esc(r.id_role),
                esc(r.nma_role),
                badge(r.status),
                ...(ubah ? [`
                    <button class="btn btn-sm btn-outline-success me-1" onclick="bukaAkses(${r.id_role})">Atur hak akses</button>
                    ${r.nma_role === 'admin' ? '' : `
                    <button class="btn btn-sm btn-outline-${r.status === 'aktif' ? 'danger' : 'primary'}"
                            onclick="ubahStatus(${r.id_role}, '${r.status === 'aktif' ? 'nonaktif' : 'aktif'}')">
                        ${r.status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'}
                    </button>`}`] : []),
            ]));
    });
}

async function bukaAkses(id) {
    roleAktif = id;
    $('modalAksesTitle').textContent = 'Hak akses: ' + roles.find(r => r.id_role === id)?.nma_role;

    try {
        const rows = await api(`/role/${id}/hak-akses`);
        $('aksesBody').innerHTML = `
            <table class="table table-sm align-middle">
                <thead><tr><th>Fitur</th>${AKSI.map(a => `<th class="text-center text-capitalize">${a}</th>`).join('')}</tr></thead>
                <tbody>
                    ${rows.map(r => `
                        <tr data-fitur="${esc(r.nm_fitur)}">
                            <td>${esc(r.nm_fitur)}</td>
                            ${AKSI.map(a => `<td class="text-center"><input type="checkbox" class="form-check-input" data-aksi="${a}" ${r[a] ? 'checked' : ''}></td>`).join('')}
                        </tr>`).join('')}
                </tbody>
            </table>`;
        bootstrap.Modal.getOrCreateInstance($('modalAkses')).show();
    } catch (e) { alert(e.message); }
}

$('btnSimpanAkses').onclick = async () => {
    const akses = [...document.querySelectorAll('#aksesBody tbody tr')].map(tr => {
        const o = { nm_fitur: tr.dataset.fitur };
        tr.querySelectorAll('input[data-aksi]').forEach(c => o[c.dataset.aksi] = c.checked);
        return o;
    });

    try {
        await kirim(`/role/${roleAktif}/hak-akses`, 'PUT', { akses });
        bootstrap.Modal.getInstance($('modalAkses')).hide();
    } catch (e) { alert(e.message); }
};

async function ubahStatus(id, status) {
    if (!confirm(`Ubah status role menjadi ${status}?`)) return;
    try { await kirim(`/role/${id}/status`, 'PUT', { status }); muatRole(); }
    catch (e) { alert(e.message); }
}

boot(muatRole);
</script>
@endsection