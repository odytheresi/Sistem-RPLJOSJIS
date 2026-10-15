{{--
    Form bersama untuk create & edit tarif.
    Variabel: $action, $chargers, $submitLabel, $confirmMessage, $tarif (opsional, saat edit)
--}}
@php
    $isEdit = isset($tarif);

    $tgl = fn ($v) => $v ? \Carbon\Carbon::parse($v)->format('Y-m-d') : '';
@endphp

<form action="{{ $action }}" method="POST" novalidate
      onsubmit="return confirm('{{ $confirmMessage }}');">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="id_charger" class="form-label">Charger</label>
        <select id="id_charger" name="id_charger"
                class="form-select form-select-lg @error('id_charger') is-invalid @enderror" required>
            <option value="">Pilih charger</option>
            @foreach ($chargers as $charger)
                <option value="{{ $charger->id_charger }}"
                    @selected((string) old('id_charger', $tarif->id_charger ?? '') === (string) $charger->id_charger)>
                    {{ $charger->kode_charger }} — {{ $charger->station->nama_station ?? '-' }}
                </option>
            @endforeach
        </select>
        @error('id_charger') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if ($chargers->isEmpty())
            <div class="form-text text-danger">
                Belum ada charger. Tambahkan charger terlebih dahulu sebelum mengatur tarif.
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="harga_per_kwh" class="form-label">Harga per kWh (Rp)</label>
        <input type="number" id="harga_per_kwh" name="harga_per_kwh" min="0" step="any"
               class="form-control form-control-lg @error('harga_per_kwh') is-invalid @enderror"
               value="{{ old('harga_per_kwh', $tarif->harga_per_kwh ?? '') }}"
               placeholder="2500" required>
        @error('harga_per_kwh') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="berlaku_mulai" class="form-label">Berlaku mulai</label>
            <input type="date" id="berlaku_mulai" name="berlaku_mulai"
                   class="form-control form-control-lg @error('berlaku_mulai') is-invalid @enderror"
                   value="{{ old('berlaku_mulai', $isEdit ? $tgl($tarif->berlaku_mulai) : now()->format('Y-m-d')) }}"
                   required>
            @error('berlaku_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label for="berlaku_selesai" class="form-label">Berlaku selesai (opsional)</label>
            <input type="date" id="berlaku_selesai" name="berlaku_selesai"
                   class="form-control form-control-lg @error('berlaku_selesai') is-invalid @enderror"
                   value="{{ old('berlaku_selesai', $isEdit ? $tgl($tarif->berlaku_selesai) : '') }}">
            @error('berlaku_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Kosongkan jika tarif berlaku tanpa batas waktu.</div>
        </div>
    </div>

    <div class="alert alert-info small">
        Jika charger ini masih punya tarif yang berjalan, tarif lama otomatis berakhir sehari
        sebelum tanggal mulai tarif ini.
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-lg">{{ $submitLabel }}</button>
        <a href="{{ route('operator.tarif.index') }}" class="btn btn-outline-secondary btn-lg">Batal</a>
    </div>
</form>