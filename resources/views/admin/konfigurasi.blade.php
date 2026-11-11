@extends('layouts.admin')
@section('title', 'Konfigurasi sistem')
@section('menu', 'konfigurasi_sistem')
@section('subtitle', 'Atur parameter dasar sistem.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive" id="konfigTable"></div>
</div>
@endsection

@section('scripts')
<script>
let konfig = [];

function muatKonfig() {
    return isi('konfigTable', async () => {
        konfig = list(await api('/konfigurasi'));
        const ubah = can('konfigurasi_sistem', 'ubah');

        return tabel(['Nama', 'Nilai', 'Deskripsi', ...(ubah ? ['Aksi'] : [])],
            konfig.map(k => [
                `<code>${esc(k.nm_konfig)}</code>`,
                ubah
                    ? `<input class="form-control form-control-sm" id="nilai_${k.id_konfig}" value="${esc(k.nilai ?? '')}">`
                    : esc(k.nilai ?? '-'),
                esc(k.deskripsi ?? '-'),
                ...(ubah ? [`<button class="btn btn-sm btn-success" onclick="simpanKonfig(${k.id_konfig})">Simpan</button>`] : []),
            ]));
    });
}

async function simpanKonfig(id) {
    const k = konfig.find(x => x.id_konfig === id);
    try {
        await kirim(`/konfigurasi/${id}`, 'PUT', {
            nm_konfig: k.nm_konfig,
            nilai: $('nilai_' + id).value,
            deskripsi: k.deskripsi,
        });
        alert('Konfigurasi disimpan.');
        muatKonfig();
    } catch (e) { alert(e.message); }
}

boot(muatKonfig);
</script>
@endsection