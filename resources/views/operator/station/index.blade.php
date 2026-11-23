@extends('layouts.operator')

@section('title', 'Charging Station')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="mb-0">Charging Station</h4>
            <small class="text-muted">Kelola lokasi charging station milik Anda.</small>
        </div>
        <a href="{{ route('operator.station.create') }}" class="btn btn-primary btn-lg">
            + Tambah Station
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Station</th>
                        <th>Alamat</th>
                        <th class="text-center">Jumlah Charger</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stations as $station)
                        @php
                            $badge = match ($station->status) {
                                'aktif'       => 'success',
                                'maintenance' => 'warning',
                                default       => 'secondary',
                            };
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $station->nama_station }}</td>
                            <td>{{ $station->alamat }}</td>
                            <td class="text-center">{{ $station->chargers_count }}</td>
                            <td>
                                <span class="badge text-bg-{{ $badge }}">{{ ucfirst($station->status) }}</span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('operator.station.show', $station) }}"
                                   class="btn btn-outline-primary btn-sm">Detail</a>
                                <a href="{{ route('operator.station.edit', $station) }}"
                                   class="btn btn-outline-secondary btn-sm">Edit</a>
                                <form action="{{ route('operator.station.destroy', $station) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus station {{ $station->nama_station }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                Belum ada charging station. Klik "Tambah Station" untuk menambahkan lokasi pertama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection