@extends('layouts.operator')

@section('title', $station->nama_station)

@section('content')
@php
    $stationBadge = match ($station->status) {
        'aktif'       => 'success',
        'maintenance' => 'warning',
        default       => 'secondary',
    };
    $chargerBadge = [
        'tersedia'    => 'success',
        'digunakan'   => 'primary',
        'maintenance' => 'warning',
        'error'       => 'danger',
    ];
    $keluhanBadge = [
        'menunggu' => 'warning',
        'diproses' => 'info',
        'selesai'  => 'success',
        'ditolak'  => 'secondary',
    ];
    $perStatus = $station->chargers->countBy('status');
@endphp

<div class="container-fluid py-3">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
        <div>
            <h4 class="mb-1">{{ $station->nama_station }}
                <span class="badge text-bg-{{ $stationBadge }} fs-6 align-middle">{{ ucfirst($station->status) }}</span>
            </h4>
            <div class="text-muted">{{ $station->alamat }}</div>
            <small class="text-muted">Koordinat: {{ $station->latitude }}, {{ $station->longitude }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('operator.station.edit', $station) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('operator.station.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    {{-- Ringkasan jumlah & status charger (FR-03) --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 col-lg">
            <div class="card shadow-sm h-100"><div class="card-body">
                <div class="text-muted small">Total charger</div>
                <div class="fs-3 fw-semibold">{{ $station->chargers->count() }}</div>
            </div></div>
        </div>
        @foreach (['tersedia' => 'Tersedia', 'digunakan' => 'Digunakan', 'maintenance' => 'Maintenance', 'error' => 'Error'] as $key => $label)
            <div class="col-6 col-md-3 col-lg">
                <div class="card shadow-sm h-100"><div class="card-body">
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fs-3 fw-semibold text-{{ $chargerBadge[$key] }}">{{ $perStatus[$key] ?? 0 }}</div>
                </div></div>
            </div>
        @endforeach
    </div>

    {{-- Daftar charger --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Daftar Charger</strong>
            <a href="{{ route('operator.charger.create') }}" class="btn btn-outline-primary btn-sm">+ Tambah Charger</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tipe Konektor</th>
                        <th>Daya Maks (kW)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($station->chargers as $charger)
                        <tr>
                            <td>
                                <a href="{{ route('operator.charger.show', $charger) }}">{{ $charger->kode_charger }}</a>
                            </td>
                            <td>{{ $charger->konektor->nama_konektor ?? '-' }}</td>
                            <td>{{ $charger->daya_maks }}</td>
                            <td>
                                <span class="badge text-bg-{{ $chargerBadge[$charger->status] ?? 'secondary' }}">
                                    {{ ucfirst($charger->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Station ini belum memiliki charger.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tarif --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Tarif</strong>
            <a href="{{ route('operator.tarif.create') }}" class="btn btn-outline-primary btn-sm">+ Atur Tarif</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Charger</th>
                        <th>Harga per kWh</th>
                        <th>Berlaku mulai</th>
                        <th>Berlaku selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($station->tarifs as $tarif)
                        <tr>
                            <td>{{ optional($station->chargers->firstWhere('id_charger', $tarif->id_charger))->kode_charger ?? 'Semua charger' }}</td>
                            <td>Rp {{ number_format($tarif->harga_per_kwh, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($tarif->berlaku_mulai)->format('d M Y') }}</td>
                            <td>{{ $tarif->berlaku_selesai ? \Carbon\Carbon::parse($tarif->berlaku_selesai)->format('d M Y') : 'Tanpa batas' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada tarif untuk station ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Keluhan --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Keluhan Pengguna</strong>
            <a href="{{ route('operator.keluhan.index') }}" class="btn btn-outline-primary btn-sm">Kelola Keluhan</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        {{-- Ganti 'isi_keluhan' dengan nama kolom di tabel keluhan milikmu --}}
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($station->keluhan as $keluhan)
                        <tr>
                            <td class="text-nowrap">{{ $keluhan->created_at?->format('d M Y') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($keluhan->isi_keluhan ?? '-', 80) }}</td>
                            <td>
                                <span class="badge text-bg-{{ $keluhanBadge[$keluhan->status] ?? 'secondary' }}">
                                    {{ ucfirst($keluhan->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('operator.keluhan.show', $keluhan) }}" class="btn btn-outline-secondary btn-sm">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada keluhan untuk station ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection