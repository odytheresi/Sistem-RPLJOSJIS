
@extends('layouts.operator')

@section('title', 'Keluhan Pengemudi')

@section('content')

@php
    $badge = [
        'menunggu' => 'warning',
        'diproses' => 'primary',
        'selesai'  => 'success',
        'ditolak'  => 'danger',
    ];

    $totalKeluhan = $keluhan->count();
    $menunggu = $keluhan->where('status', 'menunggu')->count();
    $diproses = $keluhan->where('status', 'diproses')->count();
    $selesai = $keluhan->where('status', 'selesai')->count();
@endphp

<style>
    .keluhan-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 24px;
    }

    .keluhan-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: white;
        font-size: 23px;
        border-radius: 14px;
    }

    .keluhan-stat {
        border: 0;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(37,68,125,.06);
        height: 100%;
    }

    .keluhan-stat-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 18px;
    }

    .keluhan-table {
        border: 1px solid #e8edf5;
        border-radius: 15px;
        overflow: hidden;
    }

    .keluhan-table thead th {
        background: #f5f7fb;
        color: #465775;
        font-size: 13px;
        font-weight: 700;
        padding: 16px;
        white-space: nowrap;
    }

    .keluhan-table tbody td {
        padding: 16px;
        font-size: 13px;
        color: #526078;
    }

    .keluhan-table tbody tr:hover {
        background: #f8faff;
    }

    .keluhan-detail-btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .keluhan-empty {
        padding: 55px 20px;
        text-align: center;
    }
</style>

{{-- Header --}}
<div class="keluhan-header">
    <div class="d-flex align-items-center gap-3">
        <div class="keluhan-icon">
            <i class="fas fa-comment-dots"></i>
        </div>

        <div>
            <h3 class="fw-bold mb-1">Keluhan Pengemudi</h3>
            <p class="text-secondary mb-0 small">
                Informasi dan daftar keluhan yang dikirimkan oleh pengemudi
                pada stasiun pengisian daya Anda.
            </p>
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">

    <div class="col-md-3 col-6">
        <div class="card keluhan-stat">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Keluhan</small>
                        <h3 class="fw-bold mb-0">{{ $totalKeluhan }}</h3>
                    </div>
                    <div class="keluhan-stat-icon bg-primary-subtle text-primary">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card keluhan-stat">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Menunggu</small>
                        <h3 class="fw-bold mb-0">{{ $menunggu }}</h3>
                    </div>
                    <div class="keluhan-stat-icon bg-warning-subtle text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card keluhan-stat">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Diproses</small>
                        <h3 class="fw-bold mb-0">{{ $diproses }}</h3>
                    </div>
                    <div class="keluhan-stat-icon bg-info-subtle text-info">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card keluhan-stat">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Selesai</small>
                        <h3 class="fw-bold mb-0">{{ $selesai }}</h3>
                    </div>
                    <div class="keluhan-stat-icon bg-success-subtle text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Pesan --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Tabel Keluhan --}}
<div class="card border-0 shadow-sm keluhan-table">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-1">
            <i class="fas fa-list text-primary me-2"></i>
            Daftar Keluhan
        </h5>
        <small class="text-muted">
            Keluhan yang disampaikan oleh pengemudi.
        </small>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengemudi</th>
                    <th>Lokasi Stasiun</th>
                    <th>Isi Keluhan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($keluhan as $item)

                    <tr>
                        <td class="fw-semibold">
                            #{{ $item->id_keluhan }}
                        </td>

                        <td>
                            <div class="fw-semibold text-dark">
                                Pengemudi #{{ $item->id_pengemudi ?? '-' }}
                            </div>
                            <small class="text-muted">
                                ID Pengemudi
                            </small>
                        </td>

                        <td>
                            {{ $item->station->nama_station ?? '-' }}
                        </td>

                        <td style="min-width: 220px;">
                            {{ \Illuminate\Support\Str::limit(
                                $item->isi_keluhan,
                                65
                            ) }}
                        </td>

                        <td class="text-nowrap">
                            {{ $item->created_at
                                ? $item->created_at->format('d M Y H:i')
                                : '-' }}
                        </td>

                        <td>
                            <span class="badge rounded-pill text-bg-{{ $badge[$item->status] ?? 'secondary' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('operator.keluhan.show', $item) }}"
                               class="btn btn-outline-primary btn-sm keluhan-detail-btn">
                                <i class="fas fa-eye me-1"></i>
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <div class="keluhan-empty">
                                <i class="fas fa-comment-slash fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">Belum Ada Keluhan</h5>
                                <p class="text-muted mb-0">
                                    Belum terdapat keluhan yang dikirimkan
                                    oleh pengemudi pada stasiun Anda.
                                </p>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection
