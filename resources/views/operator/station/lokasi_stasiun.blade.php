 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lokasi Stasiun - Real-Time JOSJIS</title>
    <!-- Tailwind CSS untuk styling modern -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto p-6 max-w-4xl" id="app">
        <!-- Indikator Loading saat pertama kali dibuka -->
        <div id="loading" class="text-center py-12 text-gray-600 font-medium">Memuat data stasiun secara real-time...</div>

        <!-- Konten Utama (Awalnya tersembunyi) -->
        <div id="content" class="hidden">
            <!-- Header Informasi Stasiun -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-600">
                <h1 id="station-name" class="text-2xl font-bold text-gray-800 mb-1"></h1>
                <p id="station-address" class="text-gray-600 mb-4"></p>
                <div class="flex flex-wrap gap-3 text-sm">
                    <span id="station-status" class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-medium"></span>
                    <span id="station-total" class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full font-medium"></span>
                </div>
            </div>

            <!-- Ringkasan Status Ketersediaan Charger (Real-Time FR-02) -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center shadow-sm">
                    <p class="text-xs text-green-600 font-semibold uppercase">Tersedia</p>
                    <p id="count-tersedia" class="text-3xl font-extrabold text-green-700 mt-1">0</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center shadow-sm">
                    <p class="text-xs text-amber-600 font-semibold uppercase">Digunakan</p>
                    <p id="count-digunakan" class="text-3xl font-extrabold text-amber-700 mt-1">0</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center shadow-sm">
                    <p class="text-xs text-red-600 font-semibold uppercase">Error</p>
                    <p id="count-error" class="text-3xl font-extrabold text-red-700 mt-1">0</p>
                </div>
                <div class="bg-gray-50 border border-gray-300 rounded-lg p-4 text-center shadow-sm">
                    <p class="text-xs text-gray-600 font-semibold uppercase">Perbaikan</p>
                    <p id="count-perbaikan" class="text-3xl font-extrabold text-gray-700 mt-1">0</p>
                </div>
            </div>

            <!-- Tabel Daftar Charger, Konektor, & Tarif -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Perangkat Charger, Konektor & Tarif</h2>
                    <button onclick="fetchStationData()" class="text-xs bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 font-medium">Perbarui Status</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Charger</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Konektor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Daya Maks</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarif / kWh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody id="charger-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data akan diisi otomatis melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mengambil ID stasiun secara dinamis dari rute web Laravel
        const stationId = {{ $id }};

        async function fetchStationData() {
            try {
                // Melakukan request ke API Controller yang sudah dibuat
                let response = await fetch(`/api/stations/${stationId}`);
                let result = await response.json();

                if (result.success) {
                    let station = result.data;

                    // Mengisi informasi teks stasiun
                    document.getElementById('station-name').innerText = station.nama_st;
                    document.getElementById('station-address').innerText = station.alamat;
                    document.getElementById('station-status').innerText = `Status Stasiun: ${station.status.toUpperCase()}`;
                    document.getElementById('station-total').innerText = `Total Unit: ${station.chargers.length} Charger`;

                    // Menghitung ketersediaan unit charger secara real-time
                    let tersedia = station.chargers.filter(c => c.status === 'tersedia').length;
                    let digunakan = station.chargers.filter(c => c.status === 'digunakan').length;
                    let error = station.chargers.filter(c => c.status === 'error').length;
                    let perbaikan = station.chargers.filter(c => c.status === 'perbaikan').length;

                    document.getElementById('count-tersedia').innerText = tersedia;
                    document.getElementById('count-digunakan').innerText = digunakan;
                    document.getElementById('count-error').innerText = error;
                    document.getElementById('count-perbaikan').innerText = perbaikan;

                    // Render baris data tabel charger
                    let tbody = document.getElementById('charger-table-body');
                    tbody.innerHTML = '';

                    if (station.chargers.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada perangkat charger di stasiun ini.</td></tr>`;
                    } else {
                        station.chargers.forEach(charger => {
                            let konektorName = charger.tipe_konektor ? charger.tipe_konektor.nm_konektor : '-';
                            let jenisCharging = charger.tipe_konektor ? charger.tipe_konektor.jenis_charging : '-';
                            
                            // Mendapatkan tarif terbaru
                            let tarifStr = 'Belum diatur';
                            if (charger.tarifs && charger.tarifs.length > 0) {
                                let latestTarif = charger.tarifs.reduce((prev, current) => (prev.berlaku_mulai > current.berlaku_mulai) ? prev : current);
                                tarifStr = `Rp ${Number(latestTarif.harga_per_kWh).toLocaleString('id-ID')}`;
                            }

                            // Menentukan warna badge status
                            let badgeClass = 'bg-gray-200 text-gray-800';
                            let statusText = charger.status;
                            if (charger.status === 'tersedia') {
                                badgeClass = 'bg-green-100 text-green-800';
                                statusText = 'Tersedia';
                            } else if (charger.status === 'digunakan') {
                                badgeClass = 'bg-amber-100 text-amber-800';
                                statusText = 'Sedang Digunakan';
                            } else if (charger.status === 'error') {
                                badgeClass = 'bg-red-100 text-red-800';
                                statusText = 'Error';
                            } else if (charger.status === 'perbaikan') {
                                badgeClass = 'bg-gray-200 text-gray-800';
                                statusText = 'Perbaikan';
                            }

                            let row = `
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">${charger.kd_charger}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                        ${konektorName} <span class="text-xs text-gray-400">(${jenisCharging})</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">${charger.daya_maks} kW</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">${tarifStr}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${badgeClass}">${statusText}</span>
                                    </td>
                                </tr>
                            `;
                            tbody.innerHTML += row;
                        });
                    }

                    // Sembunyikan loading, tampilkan konten
                    document.getElementById('loading').classList.add('hidden');
                    document.getElementById('content').classList.remove('hidden');
                } else {
                    document.getElementById('loading').innerText = 'Stasiun tidak ditemukan.';
                }
            } catch (error) {
                console.error('Terjadi kesalahan saat mengambil data:', error);
                document.getElementById('loading').innerText = 'Gagal memuat data dari server.';
            }
        }

        // Panggil fungsi saat halaman dimuat pertama kali
        fetchStationData();

        // Fitur Auto-Refresh: Memperbarui data secara otomatis setiap 10 detik (Real-Time FR-02)
        setInterval(fetchStationData, 10000);
    </script>
</body>
</html>