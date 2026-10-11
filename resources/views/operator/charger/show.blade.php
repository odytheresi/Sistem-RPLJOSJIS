@extends('layouts.operator')

@section('title', 'Detail Charger')

@section('content')
@php
    $badge = [
        'tersedia'    => 'success',
        'digunakan'   => 'primary',
        'maintenance' => 'warning',
        'error'       => 'danger',
    ];
    $perbaikanBadge = [
        'dijadwalkan' => 'secondary',
        'proses'      => 'info',
        'selesai'     => 'success',
        'dibatalkan'  => 'danger',
    ];
    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : '-';
@endphp

{{-- Ringkasan --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <h4 class="mb-1">{{ $charger->kode_charger }}
                <span class="badge text-bg-{{ $badge[$charger->status] ?? 'secondary' }} fs-6 align-middle">
                    {{ ucfirst($charger->status) }}
                </span>
            </h4>
            <div class="text-muted">
                Lokasi:
                @if ($charger->station)
                    <a href="{{ route('operator.station.show', $charger->station) }}">{{ $charger->station->nama_station }}</a>
                @else
                    -
                @endif
            </div>
            <div class="text-muted">
                Konektor: {{ $charger->konektor->nama_konektor ?? '-' }}
                &nbsp;|&nbsp; Daya maks: {{ $charger->daya_maks }} kW
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('operator.charger.edit', $charger) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('operator.charger.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
</div>

{{-- Tarif --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Riwayat Tarif</strong>
        <a href="{{ route('operator.tarif.create') }}" class="btn btn-outline-primary btn-sm">+ Atur Tarif</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Harga per kWh</th><th>Berlaku mulai</th><th>Berlaku selesai</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
                @forelse ($charger->tarifs->sortByDesc('berlaku_mulai') as $tarif)
                    <tr>
                        <td>Rp {{ number_format($tarif->harga_per_kwh, 0, ',', '.') }}</td>
                        <td>{{ $fmt($tarif->berlaku_mulai) }}</td>
                        <td>{{ $tarif->berlaku_selesai ? $fmt($tarif->berlaku_selesai) : 'Tanpa batas' }}</td>
                        <td>
                            @if ($tarif->sedang_berlaku)
                                <span class="badge text-bg-success">Berlaku</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada tarif untuk charger ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Maintenance --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Riwayat Maintenance</strong>
        <a href="{{ route('operator.perbaikan.create') }}" class="btn btn-outline-primary btn-sm">+ Jadwalkan Maintenance</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr><th>Tanggal jadwal</th><th>Jenis</th><th>Status</th><th>Selesai</th></tr>
            </thead>
            <tbody>
                @forelse ($charger->perbaikan->sortByDesc('tgl_jadwal') as $p)
                    <tr>
                        <td>{{ $fmt($p->tgl_jadwal) }}</td>
                        <td>{{ $p->jenis_maintenance }}</td>
                        <td>
                            <span class="badge text-bg-{{ $perbaikanBadge[$p->status] ?? 'secondary' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>{{ $fmt($p->tgl_selesai) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat maintenance.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection