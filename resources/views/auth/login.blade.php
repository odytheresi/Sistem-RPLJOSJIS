<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | EV Charging</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        /* Palet hijau yang sama dengan dashboard: #3d9e71 (utama), #2f7d59 (hover), #2a7352 (gelap) */
        :root {
            --bs-success: #3d9e71; --bs-success-rgb: 61, 158, 113;
            --bs-light:   #f5f7fb; --bs-light-rgb: 245, 247, 251;   /* latar halaman */
        }

        /* Panel kiri: gradasi hijau seperti sidebar dashboard */
        .bg-dark {
            background: linear-gradient(180deg, #3d9e71, #2a7352) !important;
        }
        .bg-dark .text-success { color: #ffffff !important; }
        .bg-dark .bg-success.bg-opacity-25 { background-color: rgba(255, 255, 255, .18) !important; }
        .bg-dark .text-white-50 { color: #d4eee1 !important; }

        /* Kartu & input */
        .card { border-radius: 15px; }
        .form-control:focus, .form-select:focus {
            border-color: #3d9e71;
            box-shadow: 0 0 0 .25rem rgba(61, 158, 113, .25);
        }

        /* Tombol */
        .btn-success {
            --bs-btn-bg: #3d9e71; --bs-btn-border-color: #3d9e71;
            --bs-btn-hover-bg: #2f7d59; --bs-btn-hover-border-color: #2f7d59;
            --bs-btn-active-bg: #2f7d59; --bs-btn-active-border-color: #2f7d59;
            --bs-btn-disabled-bg: #3d9e71; --bs-btn-disabled-border-color: #3d9e71;
            --bs-btn-focus-shadow-rgb: 61, 158, 113;
        }
        .btn-outline-success {
            --bs-btn-color: #3d9e71; --bs-btn-border-color: #3d9e71;
            --bs-btn-hover-bg: #3d9e71; --bs-btn-hover-border-color: #3d9e71;
            --bs-btn-active-bg: #3d9e71; --bs-btn-active-border-color: #3d9e71;
            --bs-btn-focus-shadow-rgb: 61, 158, 113;
        }

        /* Pesan error: merah seperti alert di dashboard */
        .alert-danger {
            --bs-alert-bg: #fee2e2;
            --bs-alert-color: #b91c1c;
            --bs-alert-border-color: #fecaca;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container-fluid">

        <div class="row min-vh-100">

            <!-- ==========================================
                 BAGIAN KIRI
            =========================================== -->

            <div class="col-lg-5 d-none d-lg-flex bg-dark text-white align-items-center justify-content-center">

                <div class="text-center px-5">

                    <div class="mb-4">
                        <i class="bi bi-lightning-charge-fill display-1 text-success"></i>
                    </div>

                    <h1 class="fw-bold display-5">
                        EV Charging
                    </h1>

                    <p class="lead text-white-50">
                        Platform Layanan Pengisian
                        Kendaraan Listrik
                    </p>

                    <p class="text-white-50 mt-4">
                        Kelola dan gunakan layanan charging
                        dengan mudah sesuai dengan peran akun Anda.
                    </p>

                    <div class="row mt-5 text-start">

                        <div class="col-12 mb-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="bi bi-lightning-charge text-success fs-4"></i>
                                </div>

                                <div>
                                    <h6 class="mb-1">
                                        Layanan Charging
                                    </h6>

                                    <small class="text-white-50">
                                        Pengisian kendaraan listrik dengan mudah
                                    </small>
                                </div>

                            </div>

                        </div>


                        <div class="col-12 mb-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="bi bi-shield-check text-success fs-4"></i>
                                </div>

                                <div>
                                    <h6 class="mb-1">
                                        Sistem Aman
                                    </h6>

                                    <small class="text-white-50">
                                        Akses diberikan sesuai role pengguna
                                    </small>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex align-items-center">

                                <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3">
                                    <i class="bi bi-speedometer2 text-success fs-4"></i>
                                </div>

                                <div>
                                    <h6 class="mb-1">
                                        Mudah Digunakan
                                    </h6>

                                    <small class="text-white-50">
                                        Semua layanan dalam satu sistem
                                    </small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==========================================
                 BAGIAN KANAN
            =========================================== -->

            <div class="col-lg-7 d-flex align-items-center justify-content-center">

                <div class="container py-5">

                    <div class="row justify-content-center">

                        <div class="col-12 col-sm-10 col-md-9 col-lg-10 col-xl-9">

                            <!-- Logo / Judul -->

                            <div class="text-center mb-4">

                                <div class="d-lg-none mb-3">
                                    <i class="bi bi-lightning-charge-fill display-3 text-success"></i>
                                </div>

                                <h2 class="fw-bold mb-2">
                                    Selamat Datang 👋
                                </h2>

                                <p class="text-muted">
                                    Silakan masuk untuk melanjutkan
                                </p>

                            </div>


                            <!-- ==========================================
                                 ERROR MESSAGE (dari validasi Laravel)
                            =========================================== -->

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">

                                    <i class="bi bi-exclamation-circle-fill me-2"></i>

                                    @if ($errors->count() === 1)
                                        {{ $errors->first() }}
                                    @else
                                        <ul class="mb-0 mt-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </div>
                            @endif


                            <!-- ==========================================
                                 LOGIN CARD
                            =========================================== -->

                            <div class="card border-0 shadow">

                                <div class="card-body p-4">

                                    <form action="{{ url('/login') }}" method="POST" id="loginForm">
                                        @csrf

                                        <!-- Nama Pengguna / Email -->

                                        <div class="mb-4">

                                            <label
                                                for="login"
                                                class="form-label fw-semibold"
                                            >
                                                Nama Pengguna atau Email
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-person"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="login"
                                                    name="login"
                                                    value="{{ old('login') }}"
                                                    placeholder="Masukkan nama pengguna atau email"
                                                    autocomplete="username"
                                                    required
                                                    autofocus
                                                >

                                            </div>

                                        </div>


                                        <!-- Password -->

                                        <div class="mb-4">

                                            <label
                                                for="pass"
                                                class="form-label fw-semibold"
                                            >
                                                Password
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-lock"></i>
                                                </span>

                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="pass"
                                                    name="pass"
                                                    placeholder="Masukkan password"
                                                    autocomplete="current-password"
                                                    required
                                                >

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-secondary"
                                                    id="togglePassword"
                                                >
                                                    <i
                                                        class="bi bi-eye"
                                                        id="passwordIcon"
                                                    ></i>
                                                </button>

                                            </div>

                                        </div>


                                        <!-- Tombol Login -->

                                        <div class="d-grid">

                                            <button
                                                type="submit"
                                                id="loginButton"
                                                class="btn btn-success btn-lg"
                                            >

                                                <i class="bi bi-box-arrow-in-right me-2"></i>

                                                Masuk

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>


                            <!-- ==========================================
                                 REGISTRASI PENGEMUDI
                            =========================================== -->



                            <!-- ==========================================
                                 FOOTER
                            =========================================== -->

                            <div class="text-center mt-4">

                                <small class="text-muted">
                                    <i class="bi bi-shield-lock me-1"></i>
                                    EV Charging Management System
                                </small>

                                <br>

                                <small class="text-muted">
                                    © 2026 EV Charging
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ==========================================
         JAVASCRIPT (hanya tampilan; login diproses oleh Laravel)
    =========================================== -->

    <script>

        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const passwordInput = document.getElementById('pass');
        const togglePassword = document.getElementById('togglePassword');
        const passwordIcon = document.getElementById('passwordIcon');


        // Tampilkan / sembunyikan password
        togglePassword.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');

            } else {

                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');

            }

        });


        // Tampilan loading saat form dikirim (form tetap dikirim normal ke Laravel)
        loginForm.addEventListener('submit', function () {

            loginButton.disabled = true;

            loginButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>' +
                'Memproses...';

        });

    </script>

</body>

</html>