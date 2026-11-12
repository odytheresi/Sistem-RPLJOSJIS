{{--
    Form bersama untuk create & edit maintenance.
    Variabel: $action, $chargers, $keluhan, $submitLabel, $perbaikan (null saat create)
--}}
@php
    $perbaikan = $perbaikan ?? null;
    $isEdit    = isset($perbaikan);
    $action    = $action ?? ($isEdit
        ? route('operator.perbaikan.update', $perbaikan)
        : route('operator.perbaikan.store'));
    $submitLabel = $submitLabel ?? ($isEdit ? 'Simpan Perubahan' : 'Simpan Maintenance');
@endphp

@if ($errors->any())
    <div class="alert alert-error">
        <strong>⚠️ Data belum dapat disimpan.</strong>
        <div class="hint" style="color:#b91c1c;margin-top:4px">Periksa kembali informasi yang Anda masukkan.</div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="dashboard-panel">
    <div class="panel-header">
        <div>
            <h3 class="section-title">Informasi Maintenance</h3>
            <div class="section-subtitle">Lengkapi informasi charger dan jadwal perawatan.</div>
        </div>
        <span class="panel-count">{{ $isEdit ? 'Mode Edit' : 'Jadwal Baru' }}</span>
    </div>

    <div class="panel-body">
        <form action="{{ $action }}" method="POST">
            @csrf

            @if ($isEdit)
                @method('PUT')
            @else
                {{-- Status awal untuk jadwal baru (dibutuhkan validasi di controller) --}}
                <input type="hidden" name="status" value="dijadwalkan">
            @endif

            {{-- Charger --}}
            <div class="form-section">🔌 Informasi Charger</div>

            <div class="form-group">
                <label for="id_charger">Pilih Charger <span class="required">*</span></label>
                <select name="id_charger" id="id_charger"
                        class="form-control @error('id_charger') is-invalid @enderror" required>
                    <option value="">Pilih charger yang akan diperbaiki</option>

                    @foreach ($chargers as $charger)
                        <option value="{{ $charger->id_charger }}"
                            @selected((string) old('id_charger', $perbaikan->id_charger ?? '') === (string) $charger->id_charger)>
                            {{ $charger->kd_charger }}
                            — {{ $charger->station->nama_st ?? 'Stasiun tidak diketahui' }}
                            ({{ ucfirst($charger->status) }})
                        </option>
                    @endforeach
                </select>

                @error('id_charger')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                @if ($chargers->isEmpty())
                    <div class="note" style="margin:8px 0 0">
                        ℹ️ <span><strong>Belum ada charger yang tersedia.</strong><br>
                        Tambahkan charger pada stasiun Anda terlebih dahulu.</span>
                    </div>
                @endif
            </div>

            {{-- Keluhan --}}
            <div class="form-group">
                <label for="id_keluhan">Keluhan Terkait</label>
                <select name="id_keluhan" id="id_keluhan"
                        class="form-control @error('id_keluhan') is-invalid @enderror">
                    <option value="">Tidak menghubungkan keluhan</option>

                    @foreach ($keluhan as $item)
                        <option value="{{ $item->id_keluhan }}"
                            @selected((string) old('id_keluhan', $perbaikan->id_keluhan ?? '') === (string) $item->id_keluhan)>
                            Keluhan #{{ $item->id_keluhan }}
                            — {{ $item->station->nama_st ?? '-' }}
                            ({{ ucfirst($item->status) }})
                        </option>
                    @endforeach
                </select>

                @error('id_keluhan')
                    <div class="field-error">{{ $message }}</div>
                @enderror

                <div class="form-text">Hubungkan maintenance dengan keluhan pengemudi jika ada.</div>
            </div>

            <hr class="divider">

            {{-- Jadwal --}}
            <div class="form-section">📅 Jadwal dan Jenis Perawatan</div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tgl_jadwal">Tanggal Maintenance <span class="required">*</span></label>
                    <input type="date" name="tgl_jadwal" id="tgl_jadwal"
                           class="form-control @error('tgl_jadwal') is-invalid @enderror"
                           value="{{ old('tgl_jadwal', isset($perbaikan) ? \Carbon\Carbon::parse($perbaikan->tgl_jadwal)->format('Y-m-d') : '') }}"
                           required>
                    @error('tgl_jadwal')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_maintenance">Jenis Maintenance <span class="required">*</span></label>
                    <select name="jenis_maintenance" id="jenis_maintenance"
                            class="form-control @error('jenis_maintenance') is-invalid @enderror" required>
                        <option value="">Pilih jenis maintenance</option>

                        @foreach ([
                            'Pemeriksaan' => 'Pemeriksaan',
                            'Perbaikan' => 'Perbaikan',
                            'Penggantian Komponen' => 'Penggantian Komponen',
                            'Pembersihan' => 'Pembersihan',
                            'Kalibrasi' => 'Kalibrasi',
                            'Lainnya' => 'Lainnya',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('jenis_maintenance', $perbaikan->jenis_maintenance ?? '') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_maintenance')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="form-group">
                <label for="keterangan">Keterangan Maintenance</label>
                <textarea name="keterangan" id="keterangan"
                          class="form-control @error('keterangan') is-invalid @enderror"
                          placeholder="Jelaskan kondisi charger atau tindakan perbaikan yang diperlukan...">{{ old('keterangan', $perbaikan->keterangan ?? '') }}</textarea>
                @error('keterangan')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status hanya muncul ketika edit --}}
            @if ($isEdit)
                <hr class="divider">

                <div class="form-section">📋 Status Maintenance</div>

                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status"
                            class="form-control @error('status') is-invalid @enderror" required>
                        @foreach ([
                            'dijadwalkan' => 'Dijadwalkan',
                            'proses' => 'Dalam Proses',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('status', $perbaikan->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="form-text">Tanggal selesai akan terisi otomatis ketika status diubah menjadi selesai.</div>
                </div>
            @else
                <div class="note">
                    ℹ️ <span><strong>Status awal: Dijadwalkan</strong><br>
                    Status akan berubah sesuai perkembangan proses maintenance.</span>
                </div>
            @endif

            {{-- Tombol --}}
            <div class="form-actions">
                <a href="{{ route('operator.perbaikan.index') }}" class="btn btn-light">← Batal</a>
                <button type="submit" class="btn">💾 {{ $submitLabel }}</button>
            </div>
        </form>
    </div>
</section>

<div class="hint" style="margin-top:4px">🛡️ Pastikan informasi charger dan jadwal maintenance sudah benar.</div>