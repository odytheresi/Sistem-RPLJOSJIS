@extends('layouts.operator')

@section('title', 'Tarif')

@section('content')
@php
    $hariIni = now()->startOfDay();

    // Status tarif: Berlaku / Akan datang / Berakhir
    $statusTarif = function ($tarif) use ($hariIni) {
        $mulai   = \Carbon\Carbon::parse($tarif->berlaku_mulai)->startOfDay();
        $selesai = $tarif->berlaku_selesai
            ? \Carbon\Carbon::parse($tarif->berlaku_selesai)->endOfDay()
            : null;

        if ($mulai->gt($hariIni)) {
            return ['Akan datang', 'info'];
        }
        if ($selesai && $selesai->lt($hariIni)) {
            return ['Berakhir', 'secondary'];
        }
        return ['Berlaku', 'success'];
    };

    $fmt = fn ($d) => $d ? \Carbon\Carbon::parse($d)->format('d M Y') : null;
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <small class="text-muted">Atur tarif per kWh untuk setiap charger. Tarif yang berlaku ditandai hijau.</small>
    <a href="{{ route('operator.tarif.create') }}" class="btn btn-primary btn-lg">+ Atur Tarif Baru</a>
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
                    <th>Lokasi Stasiun</th>
                    <th>Charger</th>
                    <th>Harga per kWh</th>
                    <th>Berlaku mulai</th>
                    <th>Berlaku selesai</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tarifs as $tarif)
                    @php [$label, $warna] = $statusTarif($tarif); @endphp
                    <tr>
                        <td>{{ $tarif->station->nama_station ?? '-' }}</td>
                        <td class="fw-semibold">{{ $tarif->charger->kode_charger ?? '-' }}</td>
                        <td>Rp {{ number_format($tarif->harga_per_kwh, 0, ',', '.') }}</td>
                        <td>{{ $fmt($tarif->berlaku_mulai) }}</td>
                        <td>{{ $fmt($tarif->berlaku_selesai) ?? 'Tanpa batas' }}</td>
                        <td><span class="badge text-bg-{{ $warna }}">{{ $label }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('operator.tarif.edit', $tarif) }}"
                               class="btn btn-outline-secondary btn-sm">Edit</a>
                            <form action="{{ route('operator.tarif.destroy', $tarif) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus tarif ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            Belum ada tarif. Klik "Atur Tarif Baru" untuk menetapkan tarif pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection