@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('menu', 'manajemen_user')
@section('subtitle', 'Daftar akun beserta role-nya. Nonaktifkan akun yang sudah tidak digunakan.')

@section('content')
<div class="row g-3 mb-3">
    <div class="col-12 col-md-6">
        <input type="text" id="cari" class="form-control" placeholder="Cari akun atau role...">
    </div>
    <div class="col-12 col-md-3">
        <select id="fStatus" class="form-select">
            <option value="">Semua status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive" id="tabelUser"></div>
</div>
@endsection

@section('scripts')
<script>
const akunSaya = JSON.parse(localStorage.getItem('user') || '{}');
let semuaUser = [];

function tampilkan() {
    const q = $('cari').value.trim().toLowerCase();
    const s = $('fStatus').value;

    const data = semuaUser.filter(u =>
        (!s || u.status === s) &&
        (!q || `${u.identifier} ${u.role?.nma_role || ''}`.toLowerCase().includes(q)));

    const baris = data.map(u => {
        const aktif = u.status === 'aktif';
        const diriSendiri = u.id_user === akunSaya.id_user;

        const tombol = diriSendiri
            ? '<span class="text-secondary small">Akun Anda</span>'
            : `<button class="btn btn-sm ${aktif ? 'btn-outline-danger' : 'btn-outline-success'}"
                       onclick="ubahStatus(${u.id_user}, '${aktif ? 'nonaktif' : 'aktif'}')">
                   ${aktif ? 'Nonaktifkan' : 'Aktifkan'}
               </button>`;

        return [
            esc(u.identifier),
            esc(u.role?.nma_role || '-'),
            `<span class="badge ${aktif ? 'bg-success' : 'bg-secondary'}">${aktif ? 'Aktif' : 'Nonaktif'}</span>`,
            tombol
        ];
    });

    $('tabelUser').innerHTML = tabel(['Akun', 'Role', 'Status', 'Aksi'], baris);
}

async function muatUser() {
    try {
        semuaUser = await api('/user');
        tampilkan();
    } catch (e) { alert(e.message); }
}

async function ubahStatus(id, status) {
    const kata = status === 'nonaktif' ? 'menonaktifkan' : 'mengaktifkan';
    if (!confirm(`Yakin ingin ${kata} akun ini?`)) return;

    try {
        await api(`/user/${id}/status`, { method: 'PUT', body: JSON.stringify({ status }) });
        muatUser();
    } catch (e) { alert(e.message); }
}

$('cari').addEventListener('input', tampilkan);
$('fStatus').addEventListener('change', tampilkan);

boot(muatUser);
</script>
@endsection