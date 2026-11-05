 @extends('layouts.operator')

@section('title', 'Maintenance Charger')

@section('content')
@php
    $statusBadge = [
        'dijadwalkan' => 'secondary',
        'proses'      => 'info',
        'selesai'     => 'success',
        'dibatalkan'  => 'danger',
    ];

    $total = $perbaikans->count();
    $dijadwalkan = $perbaikans->where('status', 'dijadwalkan')->count();
    $proses = $perbaikans->where('status', 'proses')->count();
    $selesai = $perbaikans->where('status', 'selesai')->count();
@endphp

<style>
    .maintenance-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 18px;
        padding: 26px;
        margin-bottom: 24px;
    }

    .maintenance-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: white;
        border-radius: 15px;
        font-size: 23px;
    }

    .maintenance-stat {
        background: #fff;
        border: 1px solid #e7ebf2;
        border-radius: 15px;
        padding: 20px;
        height: 100%;
    }

    .maintenance-stat .number {
        font-size: 27px;
        font-weight: 750;
        color: #263c65;
    }

    .maintenance-table {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e7ebf2;
    }

    .maintenance-table thead th {
        background: #f5f7fb;
        color: #475569;
        font-size: 13px;
        padding: 16px;
        white-space: nowrap;
    }

    .maintenance-table tbody td {
        padding: 16px;
        font-size: 13px;
        vertical-align: middle;
    }

    .maintenance-btn {
        border-radius: 9px;
        font-weight: 600;
        font-size: 13px;
    }
</style>

{{-- Header --}}
<div class="maintenance-header">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="maintenance-icon">
                <i class="fas fa-tools"></i>
            </div>

            <div>
                <h3 class="fw-bold mb-1">Maintenance Charger</h3>
                <p class="text-secondary mb-0 small">
                    Kelola jadwal dan riwayat perawatan charger pada stasiun Anda.
                </p>
            </div>
        </div>

        <a href="{{ route('operator.perbaikan.create') }}"
           class="btn btn-primary maintenance-btn px-4 py-2">
            <i class="fas fa-plus me-2"></i>
            Jadwalkan Maintenance
        </a>
    </div>
</div>

{{-- Pesan sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Statistik --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="maintenance-stat">
            <div class="text-secondary small mb-2">
                Total Maintenance
            </div>
            <div class="number">{{ $total }}</div>
            <div class="text-secondary small mt-1">Seluruh jadwal</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="maintenance-stat">
            <div class="text-secondary small mb-2">
                Dijadwalkan
            </div>
            <div class="number text-secondary">{{ $dijadwalkan }}</div>
            <div class="text-secondary small mt-1">Menunggu pelaksanaan</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="maintenance-stat">
            <div class="text-secondary small mb-2">
                Dalam Proses
            </div>
            <div class="number text-primary">{{ $proses }}</div>
            <div class="text-secondary small mt-1">Sedang diperbaiki</div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="maintenance-stat">
            <div class="text-secondary small mb-2">
                Selesai
            </div>
            <div class="number text-success">{{ $selesai }}</div>
            <div class="text-secondary small mt-1">Maintenance selesai</div>
        </div>
    </div>
</div>

{{-- Tabel Maintenance --}}
<div class="card border-0 shadow-sm maintenance-table">
    <div class="card-header bg-white border-0 px-4 py-3">
        <h5 class="fw-bold mb-1">Daftar Maintenance</h5>
        <small class="text-secondary">
            Informasi jadwal dan status perbaikan charger.
        </small>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Charger</th>
                    <th>Lokasi Stasiun</th>
                    <th>Jenis Maintenance</th>
                    <th>Tanggal Jadwal</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($perbaikans as $perbaikan)
                    <tr>
                        <td>
                            <div class="fw-bold">
                                {{ $perbaikan->charger->kode_charger ?? '-' }}
                            </div>
                            <small class="text-secondary">
                                {{ $perbaikan->charger->konektor->nama_konektor ?? '-' }}
                            </small>
                        </td>

                        <td>
                            {{ $perbaikan->charger->station->nama_station ?? '-' }}
                        </td>

                        <td>
                            {{ $perbaikan->jenis_maintenance }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($perbaikan->tgl_jadwal)->format('d M Y') }}
                        </td>

                        <td>
                            <span class="badge text-bg-{{ $statusBadge[$perbaikan->status] ?? 'secondary' }}">
                                {{ ucfirst($perbaikan->status) }}
                            </span>
                        </td>

                        <td class="text-end text-nowrap">
                            <a href="{{ route('operator.perbaikan.show', $perbaikan) }}"
                               class="btn btn-outline-primary btn-sm maintenance-btn">
                                Detail
                            </a>

                            <a href="{{ route('operator.perbaikan.edit', $perbaikan) }}"
                               class="btn btn-outline-secondary btn-sm maintenance-btn">
                                Edit
                            </a>

                            <form action="{{ route('operator.perbaikan.destroy', $perbaikan) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus jadwal maintenance ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm maintenance-btn">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-tools fa-2x text-secondary mb-3"></i>
                            <h6 class="fw-bold">Belum Ada Maintenance</h6>
                            <p class="text-secondary small mb-3">
                                Belum terdapat jadwal maintenance untuk charger Anda.
                            </p>
                            <a href="{{ route('operator.perbaikan.create') }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Buat Jadwal Maintenance
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection