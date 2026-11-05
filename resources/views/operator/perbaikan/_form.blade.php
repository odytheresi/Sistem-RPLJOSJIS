 @php
    $isEdit = isset($perbaikan);

    $statusBadge = [
        'dijadwalkan' => 'secondary',
        'proses'      => 'info',
        'selesai'     => 'success',
        'dibatalkan'  => 'danger',
    ];
@endphp

<style>
    .maintenance-form-wrapper {
        color: #24324b;
    }

    .maintenance-form-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 18px;
        padding: 27px;
        margin-bottom: 24px;
    }

    .maintenance-form-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: #fff;
        border-radius: 16px;
        font-size: 24px;
        flex-shrink: 0;
    }

    .maintenance-form-card {
        background: #fff;
        border: 1px solid #e5eaf3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(37,68,125,.06);
    }

    .maintenance-form-card-header {
        padding: 23px 28px;
        border-bottom: 1px solid #edf0f6;
    }

    .maintenance-form-body {
        padding: 28px;
    }

    .maintenance-form-wrapper .form-label {
        color: #344563;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .maintenance-form-wrapper .form-control,
    .maintenance-form-wrapper .form-select {
        min-height: 48px;
        border: 1px solid #dce3ef;
        border-radius: 10px;
        font-size: 14px;
        padding: 12px 15px;
    }

    .maintenance-form-wrapper textarea.form-control {
        min-height: 115px;
    }

    .maintenance-form-wrapper .form-control:focus,
    .maintenance-form-wrapper .form-select:focus {
        border-color: #6085ee;
        box-shadow: 0 0 0 4px rgba(71,118,230,.12);
    }

    .maintenance-form-section {
        color: #263c65;
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 18px;
    }

    .maintenance-form-info {
        display: flex;
        gap: 13px;
        padding: 17px;
        background: #eff6ff;
        border: 1px solid #dceaff;
        border-radius: 12px;
        color: #315d9b;
    }

    .maintenance-form-info i {
        font-size: 20px;
        margin-top: 2px;
    }

    .maintenance-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 24px;
        margin-top: 24px;
        border-top: 1px solid #edf0f6;
    }

    .maintenance-form-btn {
        min-height: 47px;
        padding: 11px 23px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
    }

    .maintenance-form-primary {
        color: #fff;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        border: none;
    }

    .maintenance-form-primary:hover {
        color: #fff;
        background: #3158c9;
    }

    @media(max-width:576px) {
        .maintenance-form-header,
        .maintenance-form-body,
        .maintenance-form-card-header {
            padding: 19px;
        }

        .maintenance-form-footer {
            flex-direction: column-reverse;
        }

        .maintenance-form-footer .btn {
            width: 100%;
        }
    }
</style>

<div class="maintenance-form-wrapper">

    {{-- Header --}}
    <div class="maintenance-form-header">
        <div class="d-flex align-items-center gap-3">
            <div class="maintenance-form-icon">
                <i class="fas fa-tools"></i>
            </div>

            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1">
                    {{ $isEdit ? 'Edit Maintenance' : 'Tambah Maintenance' }}
                </h3>
                <p class="text-secondary small mb-0">
                    {{ $isEdit
                        ? 'Perbarui jadwal dan informasi maintenance charger.'
                        : 'Buat jadwal perawatan untuk charger yang mengalami gangguan.' }}
                </p>
            </div>

            <span class="badge rounded-pill px-3 py-2 d-none d-md-inline-block"
                  style="background:#dce8ff;color:#3158c9;">
                <i class="fas fa-tools me-1"></i>
                {{ $isEdit ? 'Mode Edit' : 'Jadwal Baru' }}
            </span>
        </div>
    </div>

    {{-- Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4">
            <strong>
                <i class="fas fa-exclamation-circle me-2"></i>
                Data belum dapat disimpan.
            </strong>
            <p class="small mb-0 mt-1">
                Periksa kembali informasi yang kamu masukkan.
            </p>
            <ul class="small mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="maintenance-form-card">

        <div class="maintenance-form-card-header">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                Informasi Maintenance
            </h5>
            <p class="text-secondary small mb-0">
                Lengkapi informasi charger dan jadwal perawatan.
            </p>
        </div>

        <div class="maintenance-form-body">

            <form action="{{ $action }}" method="POST">
                @csrf

                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Charger --}}
                <h6 class="maintenance-form-section">
                    <i class="fas fa-charging-station me-2"></i>
                    Informasi Charger
                </h6>

                <div class="mb-4">
                    <label for="id_charger" class="form-label">
                        Pilih Charger <span class="text-danger">*</span>
                    </label>

                    <select name="id_charger" id="id_charger"
                            class="form-select @error('id_charger') is-invalid @enderror"
                            required>
                        <option value="">Pilih charger yang akan diperbaiki</option>

                        @foreach ($chargers as $charger)
                            <option value="{{ $charger->id_charger }}"
                                @selected((string) old('id_charger', $perbaikan->id_charger ?? '') === (string) $charger->id_charger)>
                                {{ $charger->kode_charger }}
                                — {{ $charger->station->nama_station ?? 'Stasiun tidak diketahui' }}
                                ({{ ucfirst($charger->status) }})
                            </option>
                        @endforeach
                    </select>

                    @error('id_charger')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($chargers->isEmpty())
                        <div class="maintenance-form-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            <div class="small">
                                <strong>Tidak ada charger yang tersedia untuk maintenance.</strong>
                                <div class="mt-1">
                                    Charger harus memiliki status error sebelum dapat dijadwalkan.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Keluhan --}}
                <div class="mb-4">
                    <label for="id_keluhan" class="form-label">
                        Keluhan Terkait
                    </label>

                    <select name="id_keluhan" id="id_keluhan"
                            class="form-select @error('id_keluhan') is-invalid @enderror">
                        <option value="">Tidak menghubungkan keluhan</option>

                        @foreach ($keluhan as $item)
                            <option value="{{ $item->id_keluhan }}"
                                @selected((string) old('id_keluhan', $perbaikan->id_keluhan ?? '') === (string) $item->id_keluhan)>
                                Keluhan #{{ $item->id_keluhan }}
                                — {{ $item->station->nama_station ?? '-' }}
                                ({{ ucfirst($item->status) }})
                            </option>
                        @endforeach
                    </select>

                    @error('id_keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-text">
                        Hubungkan maintenance dengan keluhan pengemudi jika ada.
                    </div>
                </div>

                <hr class="my-4">

                {{-- Jadwal --}}
                <h6 class="maintenance-form-section">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Jadwal dan Jenis Perawatan
                </h6>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label for="tgl_jadwal" class="form-label">
                            Tanggal Maintenance <span class="text-danger">*</span>
                        </label>

                        <input type="date" name="tgl_jadwal" id="tgl_jadwal"
                               class="form-control @error('tgl_jadwal') is-invalid @enderror"
                               value="{{ old('tgl_jadwal', isset($perbaikan) ? \Carbon\Carbon::parse($perbaikan->tgl_jadwal)->format('Y-m-d') : '') }}"
                               required>

                        @error('tgl_jadwal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_maintenance" class="form-label">
                            Jenis Maintenance <span class="text-danger">*</span>
                        </label>

                        <select name="jenis_maintenance" id="jenis_maintenance"
                                class="form-select @error('jenis_maintenance') is-invalid @enderror"
                                required>
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label for="keterangan" class="form-label">
                        Keterangan Maintenance
                    </label>

                    <textarea name="keterangan" id="keterangan"
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Jelaskan kondisi charger atau tindakan perbaikan yang diperlukan...">{{ old('keterangan', $perbaikan->keterangan ?? '') }}</textarea>

                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status hanya muncul ketika edit --}}
                @if ($isEdit)
                    <hr class="my-4">

                    <h6 class="maintenance-form-section">
                        <i class="fas fa-tasks me-2"></i>
                        Status Maintenance
                    </h6>

                    <div class="mb-4">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            Tanggal selesai akan terisi otomatis ketika status diubah menjadi selesai.
                        </div>
                    </div>
                @else
                    <div class="maintenance-form-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        <div class="small">
                            <strong>Status awal: Dijadwalkan</strong>
                            <div class="mt-1">
                                Status akan berubah sesuai perkembangan proses maintenance.
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tombol --}}
                <div class="maintenance-form-footer">
                    <a href="{{ route('operator.perbaikan.index') }}"
                       class="btn btn-light border maintenance-form-btn">
                        <i class="fas fa-arrow-left me-2"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="btn maintenance-form-primary maintenance-form-btn">
                        <i class="fas fa-save me-2"></i>
                        {{ $submitLabel }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="text-secondary small mt-3">
        <i class="fas fa-shield-alt me-1"></i>
        Pastikan informasi charger dan jadwal maintenance sudah benar.
    </div>
</div>