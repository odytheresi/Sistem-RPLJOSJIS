<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi Stasiun</title>
    <!-- Tailwind CSS untuk styling modern -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS untuk Peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto p-6 max-w-6xl">
        <!-- Header Halaman & Tombol Kembali -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Detail Lokasi Stasiun Pengisian</h1>
                <p class="text-gray-600 text-sm">Kelola dan pantau seluruh lokasi stasiun beserta perangkat charger secara menyeluruh.</p>
            </div>
            <a href="{{ route('operator.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                Kembali ke Dashboard
            </a>
        </div>

        <!-- FITUR PENCARIAN LOKASI CHARGER -->
        <div class="mb-6">
            <input type="text" id="search-station" placeholder="🔍 Cari berdasarkan nama stasiun atau alamat..." 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
        </div>

        <!-- DAFTAR STASIUN -->
        @if(isset($chargingStations) && $chargingStations->count() > 0)
            <div id="station-list" class="space-y-6">
                @foreach($chargingStations as $station)
                    <div class="station-card bg-white rounded-lg shadow-md overflow-hidden border border-gray-200"
                         data-name="{{ strtolower($station->nama_st) }}" 
                         data-address="{{ strtolower($station->alamat) }}">
                        
                        <!-- Informasi Utama Stasiun & Tombol Peta Modal -->
                        <div class="p-6 bg-gradient-to-r from-blue-50 to-white border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ $station->nama_st }}</h2>
                                <p class="text-gray-600 text-sm mt-1">📍 {{ $station->alamat }}</p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                @php
                                    $statusColor = 'bg-gray-100 text-gray-800';
                                    if(strtolower($station->status ?? '') == 'aktif' || strtolower($station->status ?? '') == 'tersedia') {
                                        $statusColor = 'bg-green-100 text-green-800';
                                    } elseif(strtolower($station->status ?? '') == 'maintenance' || strtolower($station->status ?? '') == 'perbaikan') {
                                        $statusColor = 'bg-amber-100 text-amber-800';
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    Status: {{ ucfirst($station->status ?? 'Aktif') }}
                                </span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    Total Unit: {{ $station->chargers->count() }} Charger
                                </span>

                                <!-- Tombol untuk Membuka Peta Modal -->
                                @if($station->latitude && $station->longitude)
                                    <button onclick="openMapModal('{{ addslashes($station->nama_st) }}', {{ $station->latitude }}, {{ $station->longitude }})" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow transition">
                                        🗺️ Lihat Peta
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Tabel Detail Perangkat Charger, Konektor, Tarif & Status -->
                        <div class="p-6">
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Daftar Perangkat Charger, Konektor & Tarif</h3>
                            @if($station->chargers->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Kode Charger</th>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Jenis Konektor</th>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Daya Maks</th>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Tarif / kWh</th>
                                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Status Real-Time</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            @foreach($station->chargers as $charger)
                                                @php
                                                    $konektorName = $charger->tipeKonektor ? $charger->tipeKonektor->nm_konektor : '-';
                                                    $jenisCharging = $charger->tipeKonektor ? $charger->tipeKonektor->jenis_charging : '-';
                                                    
                                                    // Ambil tarif terbaru
                                                    $tarifStr = 'Belum diatur';
                                                    if ($charger->tarifs && $charger->tarifs->count() > 0) {
                                                        $latestTarif = $charger->tarifs->sortByDesc('berlaku_mulai')->first();
                                                        $tarifStr = 'Rp ' . number_format($latestTarif->harga_per_kWh, 0, ',', '.');
                                                    }

                                                    // Warna badge status real-time
                                                    $badge = 'bg-gray-100 text-gray-800';
                                                    if ($charger->status === 'tersedia') {
                                                        $badge = 'bg-green-100 text-green-800';
                                                    } elseif ($charger->status === 'digunakan') {
                                                        $badge = 'bg-amber-100 text-amber-800';
                                                    } elseif ($charger->status === 'error') {
                                                        $badge = 'bg-red-100 text-red-800';
                                                    } elseif ($charger->status === 'perbaikan') {
                                                        $badge = 'bg-gray-200 text-gray-800';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $charger->kd_charger }}</td>
                                                    <td class="px-4 py-3 text-gray-700">
                                                        {{ $konektorName }} <span class="text-xs text-gray-400">({{ $jenisCharging }})</span>
                                                    </td>
                                                    <td class="px-4 py-3 text-gray-700">{{ $charger->daya_maks }} kW</td>
                                                    <td class="px-4 py-3 text-gray-700 font-medium">{{ $tarifStr }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full {{ $badge }}">
                                                            {{ ucfirst($charger->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm italic">Belum ada perangkat charger yang terdaftar di stasiun ini.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center text-gray-500">
                <p class="text-lg font-medium">Belum ada data lokasi stasiun yang tersedia di database.</p>
            </div>
        @endif
    </div>

    <!-- MODAL PETA LEAFLET -->
    <div id="mapModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl w-11/12 max-w-2xl p-5 relative">
            <!-- Header Modal -->
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-800">Peta Lokasi Stasiun</h3>
                <button onclick="closeMapModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold focus:outline-none">&times;</button>
            </div>
            
            <!-- Container Peta -->
            <div id="modalMap" style="height: 400px; width: 100%; border-radius: 8px;" class="z-0"></div>
        </div>
    </div>

    <!-- Leaflet JS untuk Peta -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let modalMap = null;

        function openMapModal(namaStasiun, stationLat, stationLng) {
            // Tampilkan modal
            document.getElementById('mapModal').classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'Rute ke Lokasi: ' + namaStasiun;

            // Inisialisasi peta Leaflet di dalam modal jika belum pernah dibuat
            if (!modalMap) {
                modalMap = L.map('modalMap');
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(modalMap);
            }

            // Hapus marker atau garis rute sebelumnya agar tidak menumpuk
            modalMap.eachLayer(function (layer) {
                if (layer instanceof L.Marker || layer instanceof L.Polyline) {
                    modalMap.removeLayer(layer);
                }
            });

            // Tambahkan marker titik stasiun SPKLU
            const stationMarker = L.marker([stationLat, stationLng]).addTo(modalMap)
                .bindPopup('<b>' + namaStasiun + ' (SPKLU)</b>');

            // Deteksi lokasi GPS pengguna untuk mencakup posisi Anda ke SPKLU
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Buat marker kustom untuk posisi Anda
                    const userMarker = L.marker([userLat, userLng], {
                        icon: L.divIcon({
                            className: 'custom-user-icon',
                            html: '<div style="background-color: #3b82f6; width: 14px; height: 14px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 6px rgba(0,0,0,0.6);"></div>',
                            iconSize: [14, 14]
                        })
                    }).addTo(modalMap).bindPopup('<b>📍 Posisi Anda Sekarang</b>');

                    // Buat garis rute (garis putus-putus) dari lokasi Anda ke stasiun
                    const routeLine = L.polyline([
                        [userLat, userLng],
                        [stationLat, stationLng]
                    ], {
                        color: '#2563eb',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: '6, 8'
                    }).addTo(modalMap);

                    // Sesuaikan batas peta (zoom otomatis) agar mencakup posisi Anda dan SPKLU
                    const bounds = L.latLngBounds([[userLat, userLng], [stationLat, stationLng]]);
                    modalMap.fitBounds(bounds, { padding: [50, 50] });

                    stationMarker.openPopup();
                }, function(error) {
                    // Jika GPS ditolak/gagal, fokuskan peta hanya ke lokasi stasiun
                    modalMap.setView([stationLat, stationLng], 15);
                    stationMarker.openPopup();
                }, { timeout: 10000 });
            } else {
                modalMap.setView([stationLat, stationLng], 15);
                stationMarker.openPopup();
            }

            // Memperbaiki render tile peta Leaflet yang abu-abu setelah modal terbuka
            setTimeout(() => {
                modalMap.invalidateSize();
            }, 250);
        }

        function closeMapModal() {
            // Sembunyikan modal
            document.getElementById('mapModal').classList.add('hidden');
        }

        // Tutup modal jika pengguna mengklik area luar kotak modal
        window.onclick = function(event) {
            const modal = document.getElementById('mapModal');
            if (event.target === modal) {
                closeMapModal();
            }
        }

        // Fitur Live Search Pencarian Lokasi Charger / Stasiun
        document.getElementById('search-station').addEventListener('keyup', function(e) {
            let keyword = e.target.value.toLowerCase();
            let cards = document.querySelectorAll('.station-card');

            cards.forEach(function(card) {
                let name = card.getAttribute('data-name');
                let address = card.getAttribute('data-address');

                if (name.includes(keyword) || address.includes(keyword)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>