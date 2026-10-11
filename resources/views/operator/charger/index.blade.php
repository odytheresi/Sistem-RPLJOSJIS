@extends('layouts.operator')

@section('title', 'Charger')

@section('content')
@php
    $badge = [
        'tersedia'    => 'success',
        'digunakan'   => 'primary',
        'maintenance' => 'warning',
        'error'       => 'danger',
    ];
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <small class="text-muted">Kelola charger di semua lokasi stasiun Anda.</small>
    <a href="{{ route('operator.charger.create') }}" class="btn btn-primary btn-lg">+ Tambah Charger</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Lokasi Stasiun</th>
                    <th>Tipe Konektor</th>
                    <th>Daya Maks (kW)</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($chargers as $charger)
                    <tr>
                        <td class="fw-semibold">
                            <a href="{{ route('operator.charger.show', $charger) }}">{{ $charger->kode_charger }}</a>
                        </td>
                        <td>{{ $charger->station->nama_station ?? '-' }}</td>
                        <td>{{ $charger->konektor->nama_konektor ?? '-' }}</td>
                        <td>{{ $charger->daya_maks }}</td>
                        <td style="min-width: 190px;">
                            {{-- Ubah status cepat tanpa membuka halaman edit --}}
                            <form action="{{ route('operator.charger.status', $charger) }}" method="POST"
                                  class="d-flex align-items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <span class="badge text-bg-{{ $badge[$charger->status] ?? 'secondary' }}">
                                    {{ ucfirst($charger->status) }}
                                </span>
                                <select name="status" class="form-select form-select-sm"
                                        aria-label="Ubah status {{ $charger->kode_charger }}"
                                        onchange="this.form.submit()">
                                    @foreach (['tersedia', 'digunakan', 'maintenance', 'error'] as $s)
                                        <option value="{{ $s }}" @selected($charger->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('operator.charger.show', $charger) }}"
                               class="btn btn-outline-primary btn-sm">Detail</a>
                            <a href="{{ route('operator.charger.edit', $charger) }}"
                               class="btn btn-outline-secondary btn-sm">Edit</a>
                            <form action="{{ route('operator.charger.destroy', $charger) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus charger {{ $charger->kode_charger }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            Belum ada charger. Klik "Tambah Charger" untuk menambahkan unit pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection