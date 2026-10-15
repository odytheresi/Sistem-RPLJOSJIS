
@php
    $isEdit = isset($charger);
@endphp

<style>
    .charger-form-wrapper {
        color: #24324b;
    }

    .charger-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 24px;
    }

    .charger-header-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: white;
        font-size: 25px;
        border-radius: 16px;
        flex-shrink: 0;
    }

    .charger-card {
        background: #fff;
        border: 1px solid #e5eaf3;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(37, 68, 125, .06);
        overflow: hidden;
    }

    .charger-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #edf0f6;
    }

    .charger-card-body {
        padding: 28px;
    }

    .charger-section-title {
        color: #263c65;
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 10px;
    }

    .charger-form-wrapper .form-label {
        color: #344563;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .charger-form-wrapper .form-control,
    .charger-form-wrapper .form-select {
        min-height: 48px;
        border: 1px solid #dce3ef;
        border-radius: 10px;
        font-size: 14px;
        padding: 12px 15px;
        color: #334155;
        background-color: #fff;
        transition: border-color .2s, box-shadow .2s;
    }

    .charger-form-wrapper .form-control:focus,
    .charger-form-wrapper .form-select:focus {
        border-color: #6085ee;
        box-shadow: 0 0 0 4px rgba(71, 118, 230, .12);
    }

    .charger-form-wrapper .form-control::placeholder {
        color: #a0aabd;
    }

    .charger-input-icon {
        color: #5474bd;
        margin-right: 7px;
    }

    .charger-info-box {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 17px 19px;
        background: #eff6ff;
        border: 1px solid #dceaff;
        border-radius: 12px;
        color: #315d9b;
    }

    .charger-info-box i {
        font-size: 20px;
        margin-top: 2px;
    }

    .charger-status-select {
        background-color: #f7faff !important;
    }

    .charger-tips {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: 13px;
        background: linear-gradient(135deg, #f0f5ff, #f8faff);
        border: 1px solid #e2eaff;
    }

    .charger-tips-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 15px;
        background: #dce8ff;
        color: #315ed3;
        font-size: 23px;
    }

    .charger-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 24px;
        margin-top: 24px;
        border-top: 1px solid #edf0f6;
    }

    .charger-btn {
        min-height: 48px;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s;
    }

    .charger-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        border: none;
        box-shadow: 0 5px 12px rgba(49, 88, 201, .18);
    }

    .charger-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(49, 88, 201, .25);
    }

    .charger-btn-secondary {
        color: #53627a;
        background: #fff;
        border: 1px solid #dce3ef;
    }

    .charger-btn-secondary:hover {
        color: #3158c9;
        background: #f6f8ff;
        border-color: #b8caff;
    }

    @media (max-width: 576px) {
        .charger-header,
        .charger-card-body,
        .charger-card-header {
            padding: 20px;
        }

        .charger-header-icon {
            width: 48px;
            height: 48px;
            font-size: 21px;
        }

        .charger-footer {
            flex-direction: column-reverse;
        }

        .charger-footer .btn {
            width: 100%;
        }
    }
</style>

<div class="charger-form-wrapper">

    {{-- Header --}}
    <div class="charger-header">
        <div class="d-flex align-items-center gap-3">
            <div class="charger-header-icon">
                <i class="fas fa-charging-station"></i>
            </div>

            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1">
                    {{ $isEdit ? 'Edit Data Charger' : 'Tambah Charger' }}
                </h3>
                <p class="text-secondary mb-0 small">
                    Kelola informasi charger pada stasiun pengisian daya.
                </p>
            </div>

            <span class="badge rounded-pill px-3 py-2 d-none d-md-inline-block"
                  style="background:#dce8ff;color:#3158c9;">
                <i class="fas fa-plug me-1"></i>
                {{ $isEdit ? 'Mode Edit' : 'Data Baru' }}
            </span>
        </div>
    </div>

    {{-- Pesan validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4">
            <div class="fw-bold mb-1">
                <i class="fas fa-exclamation-circle me-2"></i>
                Data belum dapat disimpan
            </div>
            <div class="small">
                Periksa kembali kolom yang ditandai dan pastikan semua data sudah benar.
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="charger-card">

        <div class="charger-card-header">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-sliders-h charger-input-icon"></i>
                Informasi Charger
            </h5>
            <p class="text-secondary small mb-0">
                Lengkapi informasi berikut sesuai kondisi charger.
            </p>
        </div>

        <div class="charger-card-body">

            <form action="{{ $action }}" method="POST">
                @csrf

                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Lokasi dan kode charger --}}
                <div class="row g-4 mb-4">

                    <div class="col-md-6">
                        <label for="id_station" class="form-label">
                            <i class="fas fa-map-marker-alt charger-input-icon"></i>
                            Lokasi Stasiun <span class="text-danger">*</span>
                        </label>

                        <select id="id_station" name="id_station"
                                class="form-select @error('id_station') is-invalid @enderror"
                                required>
                            <option value="">Pilih lokasi stasiun</option>

                            @foreach ($stations as $station)
                                <option value="{{ $station->id_station }}"
                                    @selected((string) old('id_station', $charger->id_station ?? '') === (string) $station->id_station)>
                                    {{ $station->nama_station }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_station')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($stations->isEmpty())
                            <div class="charger-info-box mt-3">
                                <i class="fas fa-info-circle"></i>
                                <div class="small">
                                    <strong>Belum ada stasiun aktif.</strong>
                                    <div class="mt-1">
                                        Tambahkan atau aktifkan stasiun terlebih dahulu.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="kode_charger" class="form-label">
                            <i class="fas fa-barcode charger-input-icon"></i>
                            Kode Charger <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="kode_charger"
                               name="kode_charger" maxlength="50"
                               class="form-control @error('kode_charger') is-invalid @enderror"
                               value="{{ old('kode_charger', $charger->kode_charger ?? '') }}"
                               placeholder="Contoh: CHG-001" required>

                        @error('kode_charger')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            Gunakan kode unik untuk setiap charger.
                        </div>
                    </div>

                </div>

                <hr class="border-light-subtle my-4">

                {{-- Tipe konektor --}}
                <div class="mb-4">
                    <label for="id_konektor" class="form-label">
                        <i class="fas fa-plug charger-input-icon"></i>
                        Tipe Konektor <span class="text-danger">*</span>
                    </label>

                    <select id="id_konektor" name="id_konektor"
                            class="form-select @error('id_konektor') is-invalid @enderror"
                            required>
                        <option value="">Pilih tipe konektor</option>

                        @foreach ($konektors as $konektor)
                            <option value="{{ $konektor->id_konektor }}"
                                @selected((string) old('id_konektor', $charger->id_konektor ?? '') === (string) $konektor->id_konektor)>
                                {{ $konektor->nama_konektor }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_konektor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="border-light-subtle my-4">

                {{-- Daya dan status --}}
                <div class="row g-4 mb-4">

                    <div class="col-md-6">
                        <label for="daya_maks" class="form-label">
                            <i class="fas fa-bolt charger-input-icon"></i>
                            Daya Maksimum (kW) <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="number" id="daya_maks"
                                   name="daya_maks" step="any" min="0"
                                   class="form-control @error('daya_maks') is-invalid @enderror"
                                   value="{{ old('daya_maks', $charger->daya_maks ?? '') }}"
                                   placeholder="Contoh: 50" required>

                            <span class="input-group-text bg-light border-0 rounded-end-3">
                                kW
                            </span>

                            @error('daya_maks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-text">
                            Masukkan daya maksimum charger.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">
                            <i class="fas fa-circle charger-input-icon"></i>
                            Status Charger <span class="text-danger">*</span>
                        </label>

                        <select id="status" name="status"
                                class="form-select charger-status-select @error('status') is-invalid @enderror"
                                required>
                            @foreach ([
                                'tersedia' => 'Tersedia',
                                'digunakan' => 'Digunakan',
                                'maintenance' => 'Maintenance',
                                'error' => 'Error'
                            ] as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(old('status', $charger->status ?? 'tersedia') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Informasi tambahan --}}
                <div class="charger-tips mt-4">
                    <div class="charger-tips-icon">
                        <i class="fas fa-charging-station"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">Periksa Kembali Data Charger</h6>
                        <p class="text-secondary small mb-0">
                            Pastikan lokasi, tipe konektor, daya, dan status
                            charger sudah sesuai sebelum menyimpan data.
                        </p>
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="charger-footer">
                    <a href="{{ route('operator.charger.index') }}"
                       class="btn charger-btn charger-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="btn charger-btn charger-btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $submitLabel }}
                    </button>
                </div>

            </form>

        </div>
    </div>

    <div class="text-secondary small mt-3 px-1">
        <i class="fas fa-shield-alt me-1"></i>
        Pastikan data yang dimasukkan sudah benar agar pengelolaan charger berjalan dengan baik.
    </div>

</div>
