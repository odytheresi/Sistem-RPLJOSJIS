{{--
    Form bersama untuk create & edit.
    Variabel: $action (URL), $station (opsional, hanya saat edit), $submitLabel
--}}
@php $isEdit = isset($station); @endphp

<form action="{{ $action }}" method="POST" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="nama_station" class="form-label">Nama station</label>
        <input type="text" id="nama_station" name="nama_station" maxlength="100"
               class="form-control form-control-lg @error('nama_station') is-invalid @enderror"
               value="{{ old('nama_station', $station->nama_station ?? '') }}" required>
        @error('nama_station') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3"
                  class="form-control @error('alamat') is-invalid @enderror"
                  required>{{ old('alamat', $station->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="number" id="latitude" name="latitude" step="any" min="-90" max="90"
                   class="form-control @error('latitude') is-invalid @enderror"
                   value="{{ old('latitude', $station->latitude ?? '') }}"
                   placeholder="-7.795580" required>
            @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="number" id="longitude" name="longitude" step="any" min="-180" max="180"
                   class="form-control @error('longitude') is-invalid @enderror"
                   value="{{ old('longitude', $station->longitude ?? '') }}"
                   placeholder="110.369490" required>
            @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <div class="form-text">Koordinat dipakai untuk menampilkan lokasi station di peta pengemudi.</div>
        </div>
    </div>

    <div class="mb-4">
        <label for="status" class="form-label">Status station</label>
        <select id="status" name="status"
                class="form-select form-select-lg @error('status') is-invalid @enderror" required>
            @foreach (['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif', 'maintenance' => 'Maintenance'] as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('status', $station->status ?? 'aktif') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-lg">{{ $submitLabel }}</button>
        <a href="{{ route('operator.station.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
    </div>
</form>