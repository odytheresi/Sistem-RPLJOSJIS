@extends('layouts.admin')
@section('title', 'Manajemen user')
@section('menu', 'manajemen_user')
@section('subtitle', 'Kelola data pengguna dan role akun.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive" id="userTable"></div>
</div>
@endsection

@section('scripts')
<script>
let roles = [];

function muatUser() {
    return isi('userTable', async () => {
        const users = list(await api('/user'));
        const bolehUbah = can('manajemen_user', 'ubah');

        return tabel(['ID', 'Identifier', 'Email', 'Role', 'Status'], users.map(u => [
            esc(u.id_user),
            esc(u.identifier),
            esc(u.email ?? '-'),
            bolehUbah && u.id_user !== me.id_user
                ? `<select class="form-select form-select-sm" onchange="ubahRole(${u.id_user}, this.value)">
                       ${roles.map(r => `<option value="${r.id_role}" ${r.id_role === u.id_role ? 'selected' : ''}>${esc(r.nma_role)}</option>`).join('')}
                   </select>`
                : esc(u.role?.nma_role),
            badge(u.status),
        ]));
    });
}

async function ubahRole(id, idRole) {
    try { await kirim(`/user/${id}/role`, 'PUT', { id_role: idRole }); }
    catch (e) { alert(e.message); }
    muatUser();
}

boot(async () => {
    roles = list(await api('/role'));
    muatUser();
});
</script>
@endsection