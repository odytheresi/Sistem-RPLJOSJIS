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

                        <!-- DIPERSEMPIT -->
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
                                 ERROR MESSAGE
                            =========================================== -->

                            <div
                                id="errorMessage"
                                class="alert alert-danger d-none"
                                role="alert"
                            >

                                <i class="bi bi-exclamation-circle-fill me-2"></i>

                                <span id="errorText"></span>

                            </div>


                            <!-- ==========================================
                                 LOGIN CARD
                            =========================================== -->

                            <div class="card border-0 shadow">

                                <div class="card-body p-4">

                                    <form id="loginForm">

                                        <!-- Username -->

                                        <div class="mb-4">

                                            <label
                                                for="username"
                                                class="form-label fw-semibold"
                                            >
                                                Username
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-person"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="username"
                                                    name="username"
                                                    placeholder="Masukkan username"
                                                    autocomplete="username"
                                                    required
                                                >

                                            </div>

                                        </div>


                                        <!-- Password -->

                                        <div class="mb-4">

                                            <label
                                                for="password"
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
                                                    id="password"
                                                    name="password"
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

                            <div class="text-center mt-4">

                                <p class="text-muted mb-2">
                                    Belum punya akun?
                                </p>

                                <a
                                    href="/register"
                                    class="btn btn-outline-success"
                                >

                                    <i class="bi bi-person-plus me-2"></i>

                                    Daftar sebagai Pengemudi

                                </a>

                            </div>


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
         JAVASCRIPT
    =========================================== -->

    <script>

        // ==========================================
        // ELEMENT
        // ==========================================

        const loginForm = document.getElementById('loginForm');

        const usernameInput = document.getElementById('username');

        const passwordInput = document.getElementById('password');

        const loginButton = document.getElementById('loginButton');

        const errorMessage = document.getElementById('errorMessage');

        const errorText = document.getElementById('errorText');

        const togglePassword = document.getElementById('togglePassword');

        const passwordIcon = document.getElementById('passwordIcon');


        // ==========================================
        // REDIRECT ADMIN
        // ==========================================

        const redirectByRole = {
            admin: '/admin/dashboard'
        };


        // ==========================================
        // SHOW / HIDE PASSWORD
        // ==========================================

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


        // ==========================================
        // RESET BUTTON
        // ==========================================

        function resetLoginButton() {

            loginButton.disabled = false;

            loginButton.innerHTML =
                '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk';

        }


        // ==========================================
        // LOGIN
        // ==========================================

        loginForm.addEventListener('submit', async function (event) {

            event.preventDefault();


            // Hilangkan error sebelumnya

            errorMessage.classList.add('d-none');


            // Ambil data dari form

            const username = usernameInput.value.trim();

            const password = passwordInput.value;


            // ==========================================
            // LOADING
            // ==========================================

            loginButton.disabled = true;

            loginButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>' +
                'Memproses...';


            try {

                // ==========================================
                // REQUEST KE API
                // ==========================================

                const response = await fetch('/api/login', {

                    method: 'POST',

                    headers: {

                        'Content-Type': 'application/json',

                        'Accept': 'application/json'

                    },

                    // PENTING:
                    // AuthController menggunakan "identifier"

                    body: JSON.stringify({

                        identifier: username,

                        password: password

                    })

                });


                // ==========================================
                // RESPONSE
                // ==========================================

                const data = await response.json();


                // ==========================================
                // JIKA LOGIN GAGAL
                // ==========================================

                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        'Username atau password salah.'
                    );

                }


                // ==========================================
                // SIMPAN TOKEN
                // ==========================================

                localStorage.setItem(
                    'token',
                    data.token
                );


                // ==========================================
                // SIMPAN DATA USER
                // ==========================================

                localStorage.setItem(
                    'user',
                    JSON.stringify(data.user)
                );


                // ==========================================
                // ADMIN
                // ==========================================

                window.location.href =
                    redirectByRole.admin;


            } catch (error) {

                errorText.textContent =
                    error.message;

                errorMessage.classList.remove(
                    'd-none'
                );

                resetLoginButton();

            }

        });

    </script>

</body>

</html>