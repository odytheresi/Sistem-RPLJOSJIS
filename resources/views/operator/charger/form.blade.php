{{--
    Form bersama untuk create & edit charger.
    Variabel: $action, $stations, $konektors, $submitLabel, $charger (opsional, saat edit)
--}}
@php
    $isEdit      = isset($charger);
    $action      = $action ?? ($isEdit
        ? route('operator.charger.update', $charger->id_charger)
        : route('operator.charger.store'));
    $submitLabel = $submitLabel ?? ($isEdit ? 'Simpan Perubahan' : 'Simpan');
@endphp

<form action="{{ $action }}" method="POST" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="id_station">Lokasi stasiun</label>
        <select id="id_station" name="id_station"
                class="form-control @error('id_station') is-invalid @enderror" required>
            <option value="">Pilih lokasi stasiun</option>
            @foreach ($stations as $station)
                <option value="{{ $station->id_station }}"
                    @selected((string) old('id_station', $charger->id_station ?? '') === (string) $station->id_station)>
                    {{ $station->nama_st }}
                </option>
            @endforeach
        </select>
        @error('id_station') <div class="field-error">{{ $message }}</div> @enderror
        @if ($stations->isEmpty())
            <div class="field-error">
                Belum ada stasiun berstatus aktif. Tambahkan atau aktifkan lokasi stasiun terlebih dahulu.
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="kd_charger">Kode charger</label>
        <input type="text" id="kd_charger" name="kd_charger" maxlength="50"
               class="form-control @error('kd_charger') is-invalid @enderror"
               value="{{ old('kd_charger', $charger->kd_charger ?? '') }}"
               placeholder="CHG-001" required>
        @error('kd_charger') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="id_konektor">Tipe konektor</label>
        <select id="id_konektor" name="id_konektor"
                class="form-control @error('id_konektor') is-invalid @enderror" required>
            <option value="">Pilih tipe konektor</option>
            @foreach ($konektors as $konektor)
                <option value="{{ $konektor->id_konektor }}"
                    @selected((string) old('id_konektor', $charger->id_konektor ?? '') === (string) $konektor->id_konektor)>
                    {{ $konektor->nm_konektor }}
                </option>
            @endforeach
        </select>
        @error('id_konektor') <div class="field-error">{{ $message }}</div> @enderror
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label for="daya_maks">Daya maksimum (kW)</label>
            <input type="number" id="daya_maks" name="daya_maks" step="any" min="0"
                   class="form-control @error('daya_maks') is-invalid @enderror"
                   value="{{ old('daya_maks', $charger->daya_maks ?? '') }}"
                   placeholder="50" required>
            @error('daya_maks') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="status">Status charger</label>
            <select id="status" name="status"
                    class="form-control @error('status') is-invalid @enderror" required>
                @foreach (['tersedia' => 'Tersedia', 'digunakan' => 'Digunakan', 'perbaikan' => 'Perbaikan', 'error' => 'Error'] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('status', $charger->status ?? 'tersedia') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <div class="field-error">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">{{ $submitLabel }}</button>
        <a href="{{ route('operator.charger.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>