@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
@endif

<div class="form-group">
    <label for="id_charger">Charger</label>
    <select id="id_charger" name="id_charger" class="form-control" required>
        <option value="">-- Pilih charger --</option>
        @foreach ($chargers as $c)
            <option value="{{ $c->id_charger }}"
                @selected(old('id_charger', $tarif->id_charger ?? '') == $c->id_charger)>
                {{ $c->kd_charger }} - {{ $c->station->nama_st ?? '-' }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="harga_per_kWh">Harga per kWh (Rp)</label>
    <input type="number" id="harga_per_kWh" name="harga_per_kWh" min="0" step="0.01" required
           class="form-control"
           value="{{ old('harga_per_kWh', $tarif->harga_per_kWh ?? '') }}">
</div>

<div class="form-group">
    <label for="berlaku_mulai">Berlaku Mulai</label>
    <input type="date" id="berlaku_mulai" name="berlaku_mulai" required
           class="form-control"
           value="{{ old('berlaku_mulai', isset($tarif) ? \Carbon\Carbon::parse($tarif->berlaku_mulai)->format('Y-m-d') : '') }}">
</div>