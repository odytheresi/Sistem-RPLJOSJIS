<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- DIUBAH: tambah meta csrf -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | EV Charging</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Palet: Persimmon #E1932C | Cornsilk #F0DF87 | Glacier #A0CED9 | Malachite #3D9E71 | Deep Atlantic #133968 */
        :root {
            --bs-success: #3D9E71; --bs-success-rgb: 61, 158, 113;
            --bs-danger:  #E1932C; --bs-danger-rgb: 225, 147, 44;
            --bs-dark:    #133968; --bs-dark-rgb: 19, 57, 104;
            --page-bg:    #FBF6DC;
        }
        body { background: var(--page-bg); }

        /* Panel kiri */
        .panel-kiri { background: linear-gradient(160deg, #133968 0%, #1c4a82 100%); }
        .bg-dark .text-success { color: #F0DF87 !important; }
        .bg-dark .bg-success.bg-opacity-25 { background-color: rgba(240,223,135,.2) !important; }
        .bg-dark .text-white-50 { color: #A0CED9 !important; }

        /* Card login */
        .card { border-radius: 1rem; }
        .input-group-text { color: #133968; }

        /* Alert error */
        .alert-danger { background: rgba(225,147,44,.15); border-color: #E1932C; color: #8a5513; }

        /* Tombol & input */
        .btn-success {
            --bs-btn-bg: #3D9E71; --bs-btn-border-color: #3D9E71;
            --bs-btn-hover-bg: #133968; --bs-btn-hover-border-color: #133968;
            --bs-btn-active-bg: #133968; --bs-btn-active-border-color: #133968;
            --bs-btn-disabled-bg: #3D9E71; --bs-btn-disabled-border-color: #3D9E71;
            --bs-btn-focus-shadow-rgb: 61, 158, 113;
        }
        .btn-outline-success {
            --bs-btn-color: #3D9E71; --bs-btn-border-color: #3D9E71;
            --bs-btn-hover-bg: #3D9E71; --bs-btn-hover-border-color: #3D9E71;
            --bs-btn-active-bg: #3D9E71; --bs-btn-active-border-color: #3D9E71;
            --bs-btn-focus-shadow-rgb: 61, 158, 113;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3D9E71;
            box-shadow: 0 0 0 .25rem rgba(61, 158, 113, .25);
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row min-vh-100">

        <!-- BAGIAN KIRI -->
        <div class="col-lg-5 d-none d-lg-flex bg-dark panel-kiri text-white align-items-center justify-content-center">
            <div class="text-center px-5">
                <div class="mb-4"><i class="bi bi-lightning-charge-fill display-1 text-success"></i></div>
                <h1 class="fw-bold display-5">EV Charging</h1>
                <p class="lead text-white-50">Platform Layanan Pengisian Kendaraan Listrik</p>
                <p class="text-white-50 mt-4">Kelola dan gunakan layanan charging dengan mudah sesuai dengan peran akun Anda.</p>

                <div class="row mt-5 text-start">
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3"><i class="bi bi-lightning-charge text-success fs-4"></i></div>
                            <div>
                                <h6 class="mb-1">Layanan Charging</h6>
                                <small class="text-white-50">Pengisian kendaraan listrik dengan mudah</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3"><i class="bi bi-shield-check text-success fs-4"></i></div>
                            <div>
                                <h6 class="mb-1">Sistem Aman</h6>
                                <small class="text-white-50">Akses diberikan sesuai role pengguna</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-25 rounded-3 p-3 me-3"><i class="bi bi-speedometer2 text-success fs-4"></i></div>
                            <div>
                                <h6 class="mb-1">Mudah Digunakan</h6>
                                <small class="text-white-50">Semua layanan dalam satu sistem</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BAGIAN KANAN -->
        <div class="col-lg-7 d-flex align-items-center justify-content-center">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-9 col-lg-10 col-xl-9">

                        <div class="text-center mb-4">
                            <div class="d-lg-none mb-3"><i class="bi bi-lightning-charge-fill display-3 text-success"></i></div>
                            <h2 class="fw-bold mb-2" style="color:#133968">Selamat Datang 👋</h2>
                            <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                        </div>

                        <div id="errorMessage" class="alert alert-danger d-none" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i><span id="errorText"></span>
                        </div>

                        <div class="card border-0 shadow">
                            <div class="card-body p-4">
                                <form id="loginForm">
                                    <div class="mb-4">
                                        <label for="username" class="form-label fw-semibold">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="username" name="username"
                                                   placeholder="Masukkan username" autocomplete="username" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="Masukkan password" autocomplete="current-password" required>
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="bi bi-eye" id="passwordIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" id="loginButton" class="btn btn-success btn-lg">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted mb-2">Belum punya akun?</p>
                            <a href="/register" class="btn btn-outline-success">
                                <i class="bi bi-person-plus me-2"></i>Daftar sebagai Pengemudi
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <small class="text-muted"><i class="bi bi-shield-lock me-1"></i>EV Charging Management System</small><br>
                            <small class="text-muted">© 2026 EV Charging</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const togglePassword = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');

    // DIUBAH: baris "const redirectByRole = { admin: '/admin/dashboard' };" dihapus,
    // karena tujuan redirect sekarang ditentukan server (data.redirect)

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

    function resetLoginButton() {
        loginButton.disabled = false;
        loginButton.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk';
    }

    loginForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        errorMessage.classList.add('d-none');

        const username = usernameInput.value.trim();
        const password = passwordInput.value;

        loginButton.disabled = true;
        loginButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        try {
            // DIUBAH: ke /login (web), kirim CSRF token, redirect sesuai role dari server
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                // PENTING: AuthController menggunakan "identifier"
                body: JSON.stringify({ identifier: username, password: password })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Username atau password salah.');
            }

            // Token hanya ada untuk admin; operator memakai sesi web
            if (data.token) {
                localStorage.setItem('token', data.token);
            } else {
                localStorage.removeItem('token');
            }
            localStorage.setItem('user', JSON.stringify(data.user));

            window.location.href = data.redirect;

        } catch (error) {
            errorText.textContent = error.message;
            errorMessage.classList.remove('d-none');
            resetLoginButton();
        }
    });
</script>
</body>
</html>