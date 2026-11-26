{{-- Partial form charger + tarif. Dipakai oleh create & edit.
     Variabel: $action, $submitLabel, $stations, $konektors, opsional $charger (mode edit) --}}
@php
    $isEdit = isset($charger) && $charger->exists;

    // Tarif yang sedang berlaku (hanya untuk mode edit)
    $tarifSaatIni = $isEdit
        ? $charger->tarifs->sortByDesc('berlaku_mulai')
            ->first(fn ($t) => \Carbon\Carbon::parse($t->berlaku_mulai)->lte(now()))
        : null;

    $hargaDefault   = old('harga_per_kWh', $tarifSaatIni->harga_per_kWh ?? '');
    $tanggalDefault = old('berlaku_mulai',
        $tarifSaatIni ? \Carbon\Carbon::parse($tarifSaatIni->berlaku_mulai)->format('Y-m-d') : now()->format('Y-m-d'));

    $stasiunTerpilih = (string) old('id_station', $charger->id_station ?? '');
    $konektorTerpilih = (string) old('id_konektor', $charger->id_konektor ?? '');
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    {{-- ===== FIELD CHARGER ===== --}}
    <div class="form-grid">
        <div class="form-group">
            <label for="kd_charger">Kode Charger</label>
            <input type="text" id="kd_charger" name="kd_charger"
                   class="form-control @error('kd_charger') is-invalid @enderror"
                   value="{{ old('kd_charger', $charger->kd_charger ?? '') }}" placeholder="mis. CHG-001" required>
            @error('kd_charger')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="id_station">Stasiun</label>
            <select id="id_station" name="id_station" class="form-control @error('id_station') is-invalid @enderror" required>
                <option value="">-- Pilih stasiun --</option>
                @foreach ($stations as $s)
                    <option value="{{ $s->id_station }}"
                        {{ $stasiunTerpilih === (string) $s->id_station ? 'selected' : '' }}>
                        {{ $s->nama_st }}
                    </option>
                @endforeach
            </select>
            @error('id_station')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="id_konektor">Tipe Konektor</label>
            <select id="id_konektor" name="id_konektor" class="form-control @error('id_konektor') is-invalid @enderror" required>
                <option value="">-- Pilih konektor --</option>
                @foreach ($konektors as $k)
                    <option value="{{ $k->id_konektor }}"
                        {{ $konektorTerpilih === (string) $k->id_konektor ? 'selected' : '' }}>
                        {{ $k->nm_konektor }}@if ($k->jenis_charging) ({{ $k->jenis_charging }})@endif
                    </option>
                @endforeach
            </select>
            @error('id_konektor')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="daya_maks">Daya Maksimum (kW)</label>
            <input type="number" id="daya_maks" name="daya_maks" step="0.1" min="0.1"
                   class="form-control @error('daya_maks') is-invalid @enderror"
                   value="{{ old('daya_maks', $charger->daya_maks ?? '') }}" required>
            @error('daya_maks')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            @if ($isEdit && $charger->status === 'digunakan')
                <input type="text" class="form-control" value="Digunakan" disabled>
                <span class="hint">Charger sedang digunakan, status tidak dapat diubah.</span>
            @else
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    @foreach (['tersedia', 'perbaikan', 'error'] as $s)
                        <option value="{{ $s }}" {{ old('status', $charger->status ?? 'tersedia') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                @error('status')<span class="field-error">{{ $message }}</span>@enderror
            @endif
        </div>
    </div>

    {{-- ===== FIELD TARIF ===== --}}
    <div class="form-section">
        <h4 class="form-section-title">💰 Tarif Pengisian</h4>
        <p class="hint" style="margin-bottom:14px">
            @if ($isEdit)
                @if ($tarifSaatIni)
                    Tarif berlaku saat ini: <strong>Rp {{ number_format($tarifSaatIni->harga_per_kWh, 0, ',', '.') }}/kWh</strong>
                    (sejak {{ \Carbon\Carbon::parse($tarifSaatIni->berlaku_mulai)->format('d M Y') }}).
                @else
                    Charger ini belum memiliki tarif berlaku.
                @endif
                Mengubah harga dengan tanggal baru akan menambah entri di riwayat tarif (riwayat lama tetap tersimpan).
            @else
                Tentukan harga pengisian per kWh untuk charger baru ini.
            @endif
        </p>

        <div class="form-grid">
            <div class="form-group">
                <label for="harga_per_kWh">Harga per kWh (Rp)</label>
                <input type="number" id="harga_per_kWh" name="harga_per_kWh" min="0" step="1"
                       class="form-control @error('harga_per_kWh') is-invalid @enderror"
                       value="{{ $hargaDefault }}" placeholder="mis. 2500" required>
                @error('harga_per_kWh')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="berlaku_mulai">Berlaku Mulai</label>
                <input type="date" id="berlaku_mulai" name="berlaku_mulai"
                       class="form-control @error('berlaku_mulai') is-invalid @enderror"
                       value="{{ $tanggalDefault }}" required>
                @error('berlaku_mulai')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">{{ $submitLabel }}</button>
        <a href="{{ $isEdit ? route('operator.charger.show', $charger->id_charger) : route('operator.charger.index') }}"
           class="btn btn-light">Batal</a>
    </div>
</form>