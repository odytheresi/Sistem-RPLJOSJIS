 @extends('layouts.operator')

@section('title', 'Detail Maintenance')

@section('content')
@php
    $statusBadge = [
        'dijadwalkan' => 'secondary',
        'proses'      => 'info',
        'selesai'     => 'success',
        'dibatalkan'  => 'danger',
    ];

    $fmt = fn($date) => $date
        ? \Carbon\Carbon::parse($date)->format('d M Y')
        : '-';
@endphp

<style>
    .maintenance-detail-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 17px;
        padding: 25px;
    }

    .maintenance-detail-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: #fff;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .maintenance-detail-card {
        border: 0;
        border-radius: 15px;
        box-shadow: 0 5px 22px rgba(37,68,125,.06);
        overflow: hidden;
    }

    .maintenance-detail-label {
        color: #718096;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .maintenance-detail-value {
        color: #263c65;
        font-size: 14px;
        font-weight: 600;
    }

    .maintenance-detail-item {
        padding: 17px;
        background: #f8faff;
        border: 1px solid #edf0f6;
        border-radius: 11px;
        height: 100%;
    }
</style>

{{-- Header --}}
<div class="maintenance-detail-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="maintenance-detail-icon">
                <i class="fas fa-tools"></i>
            </div>

            <div>
                <h3 class="fw-bold mb-1">Detail Maintenance</h3>
                <p class="text-secondary small mb-0">
                    Informasi lengkap jadwal dan riwayat perbaikan charger.
                </p>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('operator.perbaikan.edit', $perbaikan) }}"
               class="btn btn-primary">
                <i class="fas fa-edit me-1"></i>
                Edit
            </a>

            <a href="{{ route('operator.perbaikan.index') }}"
               class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- Ringkasan --}}
<div class="card maintenance-detail-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <div class="text-secondary small mb-2">Status Maintenance</div>

                <span class="badge text-bg-{{ $statusBadge[$perbaikan->status] ?? 'secondary' }} px-3 py-2">
                    {{ ucfirst($perbaikan->status) }}
                </span>

                <h4 class="fw-bold mt-3 mb-1">
                    {{ $perbaikan->jenis_maintenance }}
                </h4>

                <div class="text-secondary small">
                    Jadwal: {{ $fmt($perbaikan->tgl_jadwal) }}
                </div>
            </div>

            <div class="text-md-end">
                <div class="text-secondary small">Kode Charger</div>
                <h5 class="fw-bold text-primary mt-1">
                    {{ $perbaikan->charger->kode_charger ?? '-' }}
                </h5>
            </div>
        </div>
    </div>
</div>

{{-- Informasi charger --}}
<div class="card maintenance-detail-card mb-4">
    <div class="card-header bg-white py-3 px-4">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-charging-station text-primary me-2"></i>
            Informasi Charger
        </h5>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Kode Charger</div>
                    <div class="maintenance-detail-value">
                        {{ $perbaikan->charger->kode_charger ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Lokasi Stasiun</div>
                    <div class="maintenance-detail-value">
                        {{ $perbaikan->charger->station->nama_station ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Tipe Konektor</div>
                    <div class="maintenance-detail-value">
                        {{ $perbaikan->charger->konektor->nama_konektor ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Daya Charger</div>
                    <div class="maintenance-detail-value">
                        {{ $perbaikan->charger->daya_maks ?? '-' }} kW
                    </div>
                </div>
            </div>
        </div>

        @if ($perbaikan->charger)
            <div class="mt-3">
                <a href="{{ route('operator.charger.show', $perbaikan->charger) }}"
                   class="btn btn-outline-primary btn-sm">
                    Lihat Detail Charger
                    <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Informasi jadwal --}}
<div class="card maintenance-detail-card mb-4">
    <div class="card-header bg-white py-3 px-4">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-calendar-alt text-primary me-2"></i>
            Informasi Perawatan
        </h5>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Tanggal Jadwal</div>
                    <div class="maintenance-detail-value">
                        {{ $fmt($perbaikan->tgl_jadwal) }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Tanggal Selesai</div>
                    <div class="maintenance-detail-value">
                        {{ $fmt($perbaikan->tgl_selesai) }}
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="maintenance-detail-item">
                    <div class="maintenance-detail-label">Keterangan</div>
                    <div class="maintenance-detail-value">
                        {{ $perbaikan->keterangan ?: 'Tidak ada keterangan tambahan.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Keluhan terkait --}}
<div class="card maintenance-detail-card">
    <div class="card-header bg-white py-3 px-4">
        <h5 class="fw-bold mb-0">
            <i class="fas fa-comment-alt text-primary me-2"></i>
            Keluhan Terkait
        </h5>
    </div>

    <div class="card-body p-4">
        @if ($perbaikan->keluhan)
            <div class="maintenance-detail-item">
                <div class="maintenance-detail-label">
                    Nomor Keluhan
                </div>

                <div class="maintenance-detail-value mb-2">
                    #{{ $perbaikan->keluhan->id_keluhan }}
                </div>

                <div class="maintenance-detail-label">
                    Status Keluhan
                </div>

                <div class="maintenance-detail-value mb-2">
                    {{ ucfirst($perbaikan->keluhan->status) }}
                </div>

                <div class="maintenance-detail-label">
                    Stasiun
                </div>

                <div class="maintenance-detail-value">
                    {{ $perbaikan->keluhan->station->nama_station ?? '-' }}
                </div>
            </div>
        @else
            <div class="text-center text-secondary py-3">
                <i class="fas fa-info-circle me-1"></i>
                Maintenance ini tidak terhubung dengan keluhan tertentu.
            </div>
        @endif
    </div>
</div>
@endsection