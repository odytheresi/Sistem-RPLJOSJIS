    @extends('layouts.admin')
    @section('title', 'Laporan')
    @section('menu', 'laporan')
    @section('subtitle', 'Ringkasan sesi charging, pendapatan, kerusakan, dan aktivitas sistem per periode.')

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
            <button type="button" id="btnPdf" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-pdf me-1"></i>Unduh PDF
            </button>
        </div>
    </form>

    <div class="row g-3 mb-4" id="kartuLaporan"></div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Sesi Charging per Bulan</div>
                <div class="card-body table-responsive" id="sesiPerBulan"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Pendapatan per Stasiun</div>
                <div class="card-body table-responsive" id="pendapatanStasiun"></div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Riwayat Kerusakan Charger</div>
                <div class="card-body table-responsive" id="riwayatKerusakan"></div>
            </div>
        </div>
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
    const PER_HALAMAN = 10;
    const rp  = n => 'Rp ' + Number(n || 0).toLocaleString('id-ID');
    const num = n => Number(n || 0).toLocaleString('id-ID');

    // ---------- Pagination ----------
    const stateTabel = {};

    function renderHalaman(id, headers, rows, hal = 1) {
        stateTabel[id] = { headers, rows };

        const total = Math.max(1, Math.ceil(rows.length / PER_HALAMAN));
        hal = Math.min(Math.max(1, hal), total);

        const awal   = (hal - 1) * PER_HALAMAN;
        const potong = rows.slice(awal, awal + PER_HALAMAN);

        let nav = '';
        if (rows.length > PER_HALAMAN) {
            const dari   = Math.max(1, hal - 2);
            const sampai = Math.min(total, dari + 4);
            let angka = '';
            for (let i = Math.max(1, sampai - 4); i <= sampai; i++) {
                angka += `<li class="page-item ${i === hal ? 'active' : ''}">
                            <button type="button" class="page-link" onclick="gantiHalaman('${id}', ${i})">${i}</button>
                        </li>`;
            }

            nav = `
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                    <small class="text-secondary">
                        Menampilkan ${awal + 1}-${Math.min(awal + PER_HALAMAN, rows.length)} dari ${rows.length}
                    </small>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item ${hal === 1 ? 'disabled' : ''}">
                            <button type="button" class="page-link" onclick="gantiHalaman('${id}', ${hal - 1})">&laquo;</button>
                        </li>
                        ${angka}
                        <li class="page-item ${hal === total ? 'disabled' : ''}">
                            <button type="button" class="page-link" onclick="gantiHalaman('${id}', ${hal + 1})">&raquo;</button>
                        </li>
                    </ul>
                </div>`;
        }

        $(id).innerHTML = tabel(headers, potong) + nav;
    }

    function gantiHalaman(id, hal) {
        const s = stateTabel[id];
        if (s) renderHalaman(id, s.headers, s.rows, hal);
    }

    // ---------- Kartu ringkasan ----------
    function kartu(judul, nilai, col = 'col-6 col-md-3') {
        return `
            <div class="${col}">
                <div class="card border-0 shadow-sm h-100"><div class="card-body">
                    <p class="text-secondary mb-1">${judul}</p>
                    <h4 class="fw-bold mb-0">${nilai}</h4>
                </div></div>
            </div>`;
    }

    // ---------- Muat data laporan ----------
    async function muatLaporan() {
        const p = new URLSearchParams();
        if ($('fDari').value)   p.set('dari', $('fDari').value);
        if ($('fSampai').value) p.set('sampai', $('fSampai').value);

        try {
            const d = await api('/laporan?' + p);

            $('fDari').value   = d.periode.dari;
            $('fSampai').value = d.periode.sampai;

            const sesi = d.sesi_per_bulan || [];
            const totalSesi = sesi.reduce((a, r) => a + Number(r.jumlah_sesi || 0), 0);
            const totalKwh  = sesi.reduce((a, r) => a + Number(r.total_kwh || 0), 0);

            $('kartuLaporan').innerHTML =
                kartu('Laporan Kerusakan', num((d.kerusakan || []).length)) +
                kartu('Total Aktivitas', num(d.total_aktivitas), 'col-12 col-md-4') +
                kartu('Periode', `${esc(d.periode.dari)} s/d ${esc(d.periode.sampai)}`, 'col-12 col-md-8');

            renderHalaman('sesiPerBulan', ['Bulan', 'Jumlah Sesi', 'Energi (kWh)'],
                sesi.map(r => [esc(r.bulan), num(r.jumlah_sesi), num(Number(r.total_kwh).toFixed(2))]));

            renderHalaman('pendapatanStasiun', ['Stasiun', 'Transaksi', 'Pendapatan'],
                (d.pendapatan_per_stasiun || []).map(r => [esc(r.stasiun), num(r.jumlah_transaksi), rp(r.total_pendapatan)]));

            renderHalaman('riwayatKerusakan',
                ['Stasiun', 'Charger', 'Deskripsi', 'Dilaporkan', 'Selesai', 'Status', 'Durasi (jam)'],
                (d.kerusakan || []).map(r => [
                    esc(r.stasiun), esc(r.charger), esc(r.deskripsi || '-'),
                    esc(r.waktu_lapor || '-'), esc(r.waktu_selesai || '-'),
                    esc(r.status || '-'), num(r.durasi_jam)
                ]));

            renderHalaman('perAktivitas', ['Aktivitas', 'Jumlah'],
                (d.per_aktivitas || []).map(r => [esc(r.aktivitas), r.total]));

            renderHalaman('userTeraktif', ['User', 'Jumlah'],
                (d.user_teraktif || []).map(r => [esc(r.user?.identifier || r.id_user || '-'), r.total]));

            renderHalaman('perHari', ['Tanggal', 'Jumlah'],
                (d.per_hari || []).map(r => [esc(r.tanggal), r.total]));
        } catch (e) { alert(e.message); }
    }

    // ---------- Unduh PDF ----------
    $('btnPdf').onclick = async () => {
        const p = new URLSearchParams({ dari: $('fDari').value, sampai: $('fSampai').value });
        try {
            const res = await fetch('/api/admin/laporan/pdf?' + p, { headers: headers() });
            if (!res.ok) throw new Error('Gagal mengunduh laporan.');

            const url = URL.createObjectURL(await res.blob());
            const a = document.createElement('a');
            a.href = url;
            a.download = `laporan-${$('fDari').value}-${$('fSampai').value}.pdf`;
            a.click();
            URL.revokeObjectURL(url);
        } catch (e) { alert(e.message); }
    };

    $('laporanFilter').onsubmit = (e) => { e.preventDefault(); muatLaporan(); };

    boot(muatLaporan);
    </script>
    @endsection