
@extends('layouts.operator')

@section('title', 'Detail Keluhan')

@section('content')

@php
    $badge = [
        'menunggu' => 'warning',
        'diproses' => 'primary',
        'selesai'  => 'success',
        'ditolak'  => 'danger',
    ];
@endphp

<style>
    .keluhan-detail-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 24px;
    }

    .keluhan-detail-icon {
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

    .keluhan-detail-card {
        border: 0;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(37,68,125,.06);
        overflow: hidden;
    }

    .keluhan-detail-card .card-header {
        padding: 18px 23px;
        background: #fff;
        border-bottom: 1px solid #edf0f6;
    }

    .keluhan-detail-card .card-body {
        padding: 25px;
    }

    .keluhan-info-label {
        color: #8290a6;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .keluhan-info-value {
        color: #263650;
        font-weight: 600;
        font-size: 14px;
    }

    .keluhan-content {
        padding: 22px;
        background: #f7f9fd;
        border: 1px solid #e7edf7;
        border-radius: 12px;
        color: #344563;
        line-height: 1.8;
        white-space: pre-line;
    }
</style>

{{-- Header --}}
<div class="keluhan-detail-header">
    <div class="d-flex align-items-center gap-3">

        <div class="keluhan-detail-icon">
            <i class="fas fa-comment-dots"></i>
        </div>

        <div class="flex-grow-1">
            <h3 class="fw-bold mb-1">Detail Keluhan Pengemudi</h3>
            <p class="text-secondary small mb-0">
                Informasi lengkap keluhan yang dikirimkan oleh pengemudi.
            </p>
        </div>

        <span class="badge rounded-pill text-bg-{{ $badge[$keluhan->status] ?? 'secondary' }} px-3 py-2">
            {{ ucfirst($keluhan->status) }}
        </span>

    </div>
</div>

{{-- Informasi Keluhan --}}
<div class="card keluhan-detail-card mb-4">

    <div class="card-header">
        <h5 class="fw-bold mb-1">
            <i class="fas fa-info-circle text-primary me-2"></i>
            Informasi Keluhan
        </h5>
        <small class="text-muted">
            Identitas dan informasi pengaduan pengemudi.
        </small>
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <div class="keluhan-info-label">ID Keluhan</div>
                <div class="keluhan-info-value">
                    #{{ $keluhan->id_keluhan }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="keluhan-info-label">ID Pengemudi</div>
                <div class="keluhan-info-value">
                    {{ $keluhan->id_pengemudi ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="keluhan-info-label">Lokasi Stasiun</div>
                <div class="keluhan-info-value">
                    {{ $keluhan->station->nama_station ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="keluhan-info-label">ID Sesi Charging</div>
                <div class="keluhan-info-value">
                    {{ $keluhan->id_sesi ?? '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="keluhan-info-label">Tanggal Pengaduan</div>
                <div class="keluhan-info-value">
                    {{ $keluhan->created_at
                        ? $keluhan->created_at->format('d F Y, H:i')
                        : '-' }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="keluhan-info-label">Status Keluhan</div>
                <div>
                    <span class="badge rounded-pill text-bg-{{ $badge[$keluhan->status] ?? 'secondary' }}">
                        {{ ucfirst($keluhan->status) }}
                    </span>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Isi Keluhan --}}
<div class="card keluhan-detail-card mb-4">

    <div class="card-header">
        <h5 class="fw-bold mb-1">
            <i class="fas fa-file-alt text-primary me-2"></i>
            Isi Keluhan
        </h5>

        <small class="text-muted">
            Pesan atau permasalahan yang disampaikan pengemudi.
        </small>
    </div>

    <div class="card-body">

        <div class="keluhan-content">
            {{ $keluhan->isi_keluhan }}
        </div>

    </div>
</div>

{{-- Informasi tambahan --}}
<div class="alert alert-info border-0 rounded-3">
    <i class="fas fa-info-circle me-2"></i>
    Informasi keluhan ini hanya dapat dilihat oleh operator
    yang mengelola stasiun terkait.
</div>

{{-- Tombol --}}
<div class="d-flex justify-content-end">
    <a href="{{ route('operator.keluhan.index') }}"
       class="btn btn-outline-secondary px-4">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>
</div>

@endsection
