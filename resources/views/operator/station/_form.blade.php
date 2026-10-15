
@php
    $isEdit = isset($station);
@endphp

<style>
    .station-form-wrapper {
        color: #24324b;
    }

    .station-header {
        background: linear-gradient(135deg, #eaf1ff, #f7f9ff);
        border: 1px solid #dce7ff;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 24px;
    }

    .station-header-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        color: white;
        font-size: 24px;
        border-radius: 16px;
        flex-shrink: 0;
    }

    .station-card {
        background: #fff;
        border: 1px solid #e5eaf3;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(37, 68, 125, .06);
        overflow: hidden;
    }

    .station-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid #edf0f6;
    }

    .station-card-body {
        padding: 28px;
    }

    .station-form-wrapper .form-label {
        color: #344563;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .station-input-icon {
        color: #5474bd;
        margin-right: 7px;
    }

    .station-form-wrapper .form-control,
    .station-form-wrapper .form-select {
        min-height: 48px;
        padding: 12px 15px;
        border: 1px solid #dce3ef;
        border-radius: 10px;
        color: #334155;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .station-form-wrapper textarea.form-control {
        min-height: 115px;
        resize: vertical;
    }

    .station-form-wrapper .form-control:focus,
    .station-form-wrapper .form-select:focus {
        border-color: #6085ee;
        box-shadow: 0 0 0 4px rgba(71, 118, 230, .12);
    }

    .station-form-wrapper .form-control::placeholder {
        color: #a0aabd;
    }

    .station-section-title {
        color: #263c65;
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .station-section-subtitle {
        color: #8490a5;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .station-coordinate-box {
        background: #f7f9ff;
        border: 1px solid #e2eaff;
        border-radius: 14px;
        padding: 20px;
    }

    .station-map-info {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px 18px;
        background: #eff6ff;
        border: 1px solid #dceaff;
        border-radius: 12px;
        color: #315d9b;
    }

    .station-map-info > i {
        font-size: 20px;
        margin-top: 2px;
    }

    .station-status-select {
        background-color: #f7faff;
    }

    .station-tips {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, #f0f5ff, #f8faff);
        border: 1px solid #e2eaff;
        border-radius: 13px;
    }

    .station-tips-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #dce8ff;
        color: #315ed3;
        font-size: 23px;
        border-radius: 15px;
    }

    .station-form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 24px;
        margin-top: 24px;
        border-top: 1px solid #edf0f6;
    }

    .station-btn {
        min-height: 48px;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: all .2s;
    }

    .station-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #4776e6, #3158c9);
        border: none;
        box-shadow: 0 5px 12px rgba(49, 88, 201, .18);
    }

    .station-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(49, 88, 201, .25);
    }

    .station-btn-secondary {
        color: #53627a;
        background: #fff;
        border: 1px solid #dce3ef;
    }

    .station-btn-secondary:hover {
        color: #3158c9;
        background: #f6f8ff;
        border-color: #b8caff;
    }

    @media (max-width: 576px) {
        .station-header,
        .station-card-header,
        .station-card-body {
            padding: 20px;
        }

        .station-header-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .station-form-footer {
            flex-direction: column-reverse;
        }

        .station-form-footer .btn {
            width: 100%;
        }
    }
</style>

<div class="station-form-wrapper">

    {{-- Header --}}
    <div class="station-header">
        <div class="d-flex align-items-center gap-3">
            <div class="station-header-icon">
                <i class="fas fa-charging-station"></i>
            </div>

            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1">
                    {{ $isEdit ? 'Edit Data Stasiun' : 'Tambah Stasiun' }}
                </h3>
                <p class="text-secondary small mb-0">
                    Kelola informasi lokasi stasiun pengisian kendaraan listrik.
                </p>
            </div>

            <span class="badge rounded-pill px-3 py-2 d-none d-md-inline-block"
                  style="background:#dce8ff;color:#3158c9;">
                <i class="fas fa-map-marked-alt me-1"></i>
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
                Periksa kembali kolom yang ditandai dan pastikan data sudah benar.
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="station-card">

        <div class="station-card-header">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-map-marker-alt station-input-icon"></i>
                Informasi Stasiun
            </h5>
            <p class="text-secondary small mb-0">
                Lengkapi informasi identitas dan lokasi stasiun.
            </p>
        </div>

        <div class="station-card-body">

            <form action="{{ $action }}" method="POST">
                @csrf

                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Nama stasiun --}}
                <div class="mb-4">
                    <label for="nama_station" class="form-label">
                        <i class="fas fa-charging-station station-input-icon"></i>
                        Nama Stasiun <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           id="nama_station"
                           name="nama_station"
                           maxlength="100"
                           class="form-control @error('nama_station') is-invalid @enderror"
                           value="{{ old('nama_station', $station->nama_station ?? '') }}"
                           placeholder="Contoh: EV Charging Station Malioboro"
                           required>

                    @error('nama_station')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label for="alamat" class="form-label">
                        <i class="fas fa-map-marked-alt station-input-icon"></i>
                        Alamat Lengkap <span class="text-danger">*</span>
                    </label>

                    <textarea id="alamat"
                              name="alamat"
                              rows="3"
                              class="form-control @error('alamat') is-invalid @enderror"
                              placeholder="Masukkan alamat lengkap lokasi stasiun"
                              required>{{ old('alamat', $station->alamat ?? '') }}</textarea>

                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="border-light-subtle my-4">

                {{-- Koordinat --}}
                <div class="station-coordinate-box mb-4">

                    <div class="mb-4">
                        <h6 class="station-section-title">
                            <i class="fas fa-location-arrow station-input-icon"></i>
                            Koordinat Lokasi
                        </h6>
                        <p class="station-section-subtitle mb-0">
                            Masukkan titik koordinat geografis stasiun.
                        </p>
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label for="latitude" class="form-label">
                                Latitude <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   id="latitude"
                                   name="latitude"
                                   step="any"
                                   min="-90"
                                   max="90"
                                   class="form-control @error('latitude') is-invalid @enderror"
                                   value="{{ old('latitude', $station->latitude ?? '') }}"
                                   placeholder="-7.795580"
                                   required>

                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">Rentang nilai: -90 sampai 90.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="longitude" class="form-label">
                                Longitude <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                   id="longitude"
                                   name="longitude"
                                   step="any"
                                   min="-180"
                                   max="180"
                                   class="form-control @error('longitude') is-invalid @enderror"
                                   value="{{ old('longitude', $station->longitude ?? '') }}"
                                   placeholder="110.369490"
                                   required>

                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">Rentang nilai: -180 sampai 180.</div>
                        </div>

                    </div>

                    <div class="station-map-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        <div class="small">
                            <strong>Informasi lokasi</strong>
                            <p class="mb-0 mt-1">
                                Koordinat digunakan untuk membantu menampilkan
                                posisi stasiun pada peta di halaman pengemudi.
                                Pastikan titik lokasi yang dimasukkan sudah tepat.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label for="status" class="form-label">
                        <i class="fas fa-toggle-on station-input-icon"></i>
                        Status Stasiun <span class="text-danger">*</span>
                    </label>

                    <select id="status"
                            name="status"
                            class="form-select station-status-select @error('status') is-invalid @enderror"
                            required>
                        @foreach ([
                            'aktif' => 'Aktif',
                            'nonaktif' => 'Nonaktif',
                            'maintenance' => 'Maintenance'
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('status', $station->status ?? 'aktif') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-text">
                        Pilih status sesuai kondisi operasional stasiun.
                    </div>
                </div>

                {{-- Informasi tambahan --}}
                <div class="station-tips mt-4">
                    <div class="station-tips-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">Periksa Data Stasiun</h6>
                        <p class="text-secondary small mb-0">
                            Pastikan nama, alamat, koordinat, dan status sudah
                            benar sebelum menyimpan data stasiun.
                        </p>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="station-form-footer">

                    <a href="{{ route('operator.station.index') }}"
                       class="btn station-btn station-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Batal
                    </a>

                    <button type="submit"
                            class="btn station-btn station-btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $submitLabel }}
                    </button>

                </div>

            </form>

        </div>
    </div>

    <div class="text-secondary small mt-3 px-1">
        <i class="fas fa-shield-alt me-1"></i>
        Informasi stasiun yang tersimpan dapat dikelola kembali melalui halaman daftar stasiun.
    </div>

</div>
