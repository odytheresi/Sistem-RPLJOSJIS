{{--
    Form bersama untuk create & edit charger.
    Variabel: $action, $stations, $konektors, $submitLabel, $charger (opsional, saat edit)
--}}
@php $isEdit = isset($charger); @endphp

<form action="{{ $action }}" method="POST" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="id_station" class="form-label">Lokasi stasiun</label>
        <select id="id_station" name="id_station"
                class="form-select form-select-lg @error('id_station') is-invalid @enderror" required>
            <option value="">Pilih lokasi stasiun</option>
            @foreach ($stations as $station)
                <option value="{{ $station->id_station }}"
                    @selected((string) old('id_station', $charger->id_station ?? '') === (string) $station->id_station)>
                    {{ $station->nama_station }}
                </option>
            @endforeach
        </select>
        @error('id_station') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if ($stations->isEmpty())
            <div class="form-text text-danger">
                Belum ada stasiun berstatus aktif. Tambahkan atau aktifkan lokasi stasiun terlebih dahulu.
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="kode_charger" class="form-label">Kode charger</label>
        <input type="text" id="kode_charger" name="kode_charger" maxlength="50"
               class="form-control form-control-lg @error('kode_charger') is-invalid @enderror"
               value="{{ old('kode_charger', $charger->kode_charger ?? '') }}"
               placeholder="CHG-001" required>
        @error('kode_charger') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="id_konektor" class="form-label">Tipe konektor</label>
        <select id="id_konektor" name="id_konektor"
                class="form-select form-select-lg @error('id_konektor') is-invalid @enderror" required>
            <option value="">Pilih tipe konektor</option>
            @foreach ($konektors as $konektor)
                <option value="{{ $konektor->id_konektor }}"
                    @selected((string) old('id_konektor', $charger->id_konektor ?? '') === (string) $konektor->id_konektor)>
                    {{ $konektor->nama_konektor }}
                </option>
            @endforeach
        </select>
        @error('id_konektor') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="daya_maks" class="form-label">Daya maksimum (kW)</label>
            <input type="number" id="daya_maks" name="daya_maks" step="any" min="0"
                   class="form-control form-control-lg @error('daya_maks') is-invalid @enderror"
                   value="{{ old('daya_maks', $charger->daya_maks ?? '') }}"
                   placeholder="50" required>
            @error('daya_maks') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status charger</label>
            <select id="status" name="status"
                    class="form-select form-select-lg @error('status') is-invalid @enderror" required>
                @foreach (['tersedia' => 'Tersedia', 'digunakan' => 'Digunakan', 'maintenance' => 'Maintenance', 'error' => 'Error'] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('status', $charger->status ?? 'tersedia') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-lg">{{ $submitLabel }}</button>
        <a href="{{ route('operator.charger.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
    </div>
</form>