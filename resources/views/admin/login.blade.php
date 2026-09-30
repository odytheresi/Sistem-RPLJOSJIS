```php
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin | EV Charging</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>

<body class="bg-light">

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">

            <!-- Bagian Kiri -->
            <div class="col-lg-6 d-none d-lg-flex bg-dark text-white
                        align-items-center justify-content-center">

                <div class="text-center px-5">

                    <div class="mb-4">
                        <i class="bi bi-lightning-charge-fill display-1 text-success"></i>
                    </div>

                    <h1 class="fw-bold display-5">
                        EV Charging
                    </h1>

                    <p class="lead text-secondary">
                        Admin Management System
                    </p>

                    <p class="text-white-50 mt-4">
                        Kelola pengguna, stasiun pengisian,
                        transaksi, dan layanan charging
                        melalui satu sistem terintegrasi.
                    </p>

                </div>

            </div>


            <!-- Bagian Kanan -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">

                <div class="w-100 px-4" style="max-width: 450px;">

                    <!-- Logo -->
                    <div class="text-center mb-4">

                        <div class="mb-3">
                            <i class="bi bi-ev-front-fill fs-1 text-success"></i>
                        </div>

                        <h2 class="fw-bold">
                            Admin Login
                        </h2>

                        <p class="text-muted">
                            Masuk ke sistem EV Charging
                        </p>

                    </div>


                    <!-- Error -->
                    <div
                        id="errorMessage"
                        class="alert alert-danger d-none"
                        role="alert"
                    ></div>


                    <!-- Form -->
                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4">

                            <form id="loginForm">

                                <!-- Username -->
                                <div class="mb-3">

                                    <label
                                        for="identifier"
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
                                            id="identifier"
                                            name="identifier"
                                            placeholder="Masukkan username"
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
                                            required
                                        >

                                    </div>

                                </div>


                                <!-- Button -->
                                <button
                                    type="submit"
                                    id="loginButton"
                                    class="btn btn-success w-100 py-2 fw-semibold"
                                >
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Login
                                </button>

                            </form>

                        </div>

                    </div>


                    <p class="text-center text-muted small mt-4">
                        EV Charging Management System
                    </p>

                </div>

            </div>

        </div>
    </div>


    <script>

        const loginForm = document.getElementById('loginForm');
        const errorMessage = document.getElementById('errorMessage');
        const loginButton = document.getElementById('loginButton');

        loginForm.addEventListener('submit', async function (event) {

            event.preventDefault();

            errorMessage.classList.add('d-none');

            const identifier =
                document.getElementById('identifier').value;

            const password =
                document.getElementById('password').value;


            loginButton.disabled = true;
            loginButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';


            try {

                const response = await fetch('/api/login', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },

                    body: JSON.stringify({
                        identifier: identifier,
                        password: password
                    })

                });


                const data = await response.json();


                if (!response.ok) {

                    throw new Error(
                        data.message || 'Login gagal'
                    );

                }


                // Simpan token
                localStorage.setItem(
                    'token',
                    data.token
                );


                // Simpan data user
                localStorage.setItem(
                    'user',
                    JSON.stringify(data.user)
                );


                // Masuk dashboard
                window.location.href =
                    '/admin/dashboard';


            } catch (error) {

                errorMessage.textContent =
                    error.message;

                errorMessage.classList.remove('d-none');

            } finally {

                loginButton.disabled = false;

                loginButton.innerHTML =
                    '<i class="bi bi-box-arrow-in-right me-2"></i>Login';

            }

        });

    </script>

</body>

</html>
```
