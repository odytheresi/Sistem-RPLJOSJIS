<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | EV Charging</title>

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

    <div class="container-fluid">

        <div class="row min-vh-100">


            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 bg-dark text-white p-0">

                <!-- Logo -->
                <div class="p-4">

                    <div class="d-flex align-items-center">

                        <i class="bi bi-lightning-charge-fill fs-3 text-success me-2"></i>

                        <div>

                            <h5 class="mb-0 fw-bold">
                                EV Charging
                            </h5>

                            <small class="text-secondary">
                                Admin Management
                            </small>

                        </div>

                    </div>

                </div>


                <hr class="text-secondary m-0">


                <!-- Menu -->
                <div class="p-3">

                    <p class="text-uppercase text-secondary small px-2">
                        Menu Utama
                    </p>


                    <!-- Dashboard -->
                    <a
                        href="/admin/dashboard"
                        class="btn btn-success w-100 text-start mb-2"
                    >

                        <i class="bi bi-grid-fill me-2"></i>

                        Dashboard

                    </a>


                    <!-- Pengguna -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-people me-2"></i>

                        Pengguna

                    </a>


                    <!-- Operator -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-person-badge me-2"></i>

                        Operator

                    </a>


                    <!-- Stasiun Charging -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-ev-front me-2"></i>

                        Stasiun Charging

                    </a>


                    <!-- Charger -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-lightning-charge me-2"></i>

                        Charger

                    </a>


                    <!-- Transaksi -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-receipt me-2"></i>

                        Transaksi

                    </a>


                    <hr class="text-secondary my-4">


                    <p class="text-uppercase text-secondary small px-2">
                        Sistem
                    </p>


                    <!-- Hak Akses -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-shield-lock me-2"></i>

                        Hak Akses

                    </a>


                    <!-- Pengaturan -->
                    <a
                        href="#"
                        class="btn btn-dark w-100 text-start mb-2"
                    >

                        <i class="bi bi-gear me-2"></i>

                        Pengaturan

                    </a>

                </div>

            </div>



            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-lg-10 p-0">


                <!-- NAVBAR -->
                <nav class="navbar bg-white border-bottom px-4 py-3">

                    <span class="fw-semibold">
                        Dashboard
                    </span>


                    <!-- Admin -->
                    <div class="dropdown">

                        <button
                            class="btn btn-light dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                        >

                            <i class="bi bi-person-circle me-2"></i>

                            <span id="navbarName">
                                Admin
                            </span>

                        </button>


                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>

                                <a
                                    class="dropdown-item"
                                    href="#"
                                >

                                    <i class="bi bi-person me-2"></i>

                                    Profil

                                </a>

                            </li>


                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            <li>

                                <button
                                    class="dropdown-item text-danger"
                                    onclick="logout()"
                                >

                                    <i class="bi bi-box-arrow-right me-2"></i>

                                    Logout

                                </button>

                            </li>

                        </ul>

                    </div>

                </nav>



                <!-- CONTENT -->
                <main class="p-4">


                    <!-- WELCOME -->
                    <div class="mb-4">

                        <h2 class="fw-bold">

                            Selamat datang,

                            <span id="namaAdmin">
                                Admin
                            </span>!

                        </h2>


                        <p class="text-muted">

                            Selamat datang di halaman administrasi
                            EV Charging Management System.

                        </p>

                    </div>



                    <!-- STATISTIC -->
                    <div class="row g-4 mb-4">


                        <!-- Total Pengguna -->
                        <div class="col-md-6 col-xl-3">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <p class="text-muted mb-1">
                                                Total Pengguna
                                            </p>

                                            <h3 class="fw-bold mb-0">
                                                120
                                            </h3>

                                        </div>


                                        <i class="bi bi-people text-success fs-1"></i>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- Operator -->
                        <div class="col-md-6 col-xl-3">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <p class="text-muted mb-1">
                                                Operator
                                            </p>

                                            <h3 class="fw-bold mb-0">
                                                15
                                            </h3>

                                        </div>


                                        <i class="bi bi-person-badge text-primary fs-1"></i>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- Stasiun -->
                        <div class="col-md-6 col-xl-3">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <p class="text-muted mb-1">
                                                Stasiun Charging
                                            </p>

                                            <h3 class="fw-bold mb-0">
                                                12
                                            </h3>

                                        </div>


                                        <i class="bi bi-ev-front text-success fs-1"></i>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- Charger -->
                        <div class="col-md-6 col-xl-3">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <p class="text-muted mb-1">
                                                Total Charger
                                            </p>

                                            <h3 class="fw-bold mb-0">
                                                35
                                            </h3>

                                        </div>


                                        <i class="bi bi-lightning-charge text-warning fs-1"></i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- BOTTOM SECTION -->
                    <div class="row g-4">


                        <!-- Ringkasan Sistem -->
                        <div class="col-lg-8">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body p-4">

                                    <h5 class="fw-bold mb-4">

                                        <i class="bi bi-speedometer2 text-success me-2"></i>

                                        Ringkasan Sistem

                                    </h5>


                                    <!-- Status -->
                                    <div class="alert alert-success">

                                        <i class="bi bi-check-circle-fill me-2"></i>

                                        Sistem EV Charging
                                        sedang berjalan dengan normal.

                                    </div>


                                    <!-- Charger Status -->
                                    <div class="row text-center mt-4">


                                        <!-- Aktif -->
                                        <div class="col-md-4">

                                            <div class="border rounded p-3">

                                                <i class="bi bi-lightning-charge-fill text-success fs-3"></i>

                                                <h4 class="fw-bold mt-2">
                                                    28
                                                </h4>

                                                <p class="text-muted mb-0">
                                                    Charger Aktif
                                                </p>

                                            </div>

                                        </div>


                                        <!-- Digunakan -->
                                        <div class="col-md-4">

                                            <div class="border rounded p-3">

                                                <i class="bi bi-car-front-fill text-primary fs-3"></i>

                                                <h4 class="fw-bold mt-2">
                                                    7
                                                </h4>

                                                <p class="text-muted mb-0">
                                                    Sedang Digunakan
                                                </p>

                                            </div>

                                        </div>


                                        <!-- Tidak Aktif -->
                                        <div class="col-md-4">

                                            <div class="border rounded p-3">

                                                <i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>

                                                <h4 class="fw-bold mt-2">
                                                    5
                                                </h4>

                                                <p class="text-muted mb-0">
                                                    Tidak Aktif
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- PROFIL ADMIN -->
                        <div class="col-lg-4">

                            <div class="card border-0 shadow-sm h-100">

                                <div class="card-body p-4 text-center">


                                    <h5 class="fw-bold mb-4 text-start">

                                        <i class="bi bi-person-vcard text-success me-2"></i>

                                        Profil Admin

                                    </h5>


                                    <!-- Icon -->
                                    <div class="mb-3">

                                        <i class="bi bi-person-circle display-3 text-success"></i>

                                    </div>


                                    <!-- Nama -->
                                    <h4
                                        id="profileName"
                                        class="fw-bold"
                                    >
                                        Admin
                                    </h4>


                                    <!-- Role -->
                                    <p class="text-muted mb-1">
                                        Administrator
                                    </p>


                                    <!-- Email -->
                                    <p
                                        id="profileEmail"
                                        class="text-muted small"
                                    >
                                        -
                                    </p>


                                    <hr>


                                    <!-- Username -->
                                    <div class="text-start">

                                        <p class="mb-3">

                                            <i class="bi bi-person me-2 text-success"></i>

                                            <span id="profileUsername">
                                                -
                                            </span>

                                        </p>


                                        <!-- Status -->
                                        <p class="mb-0">

                                            <i class="bi bi-circle-fill me-2 text-success"></i>

                                            <span class="text-success">
                                                Akun Aktif
                                            </span>

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- INFO -->
                    <div class="card border-0 shadow-sm mt-4">

                        <div class="card-body p-4">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-info-circle-fill text-success fs-3 me-3"></i>

                                <div>

                                    <h6 class="fw-bold mb-1">
                                        Admin Dashboard
                                    </h6>

                                    <p class="text-muted mb-0 small">

                                        Gunakan menu di sebelah kiri
                                        untuk mengelola data dan layanan
                                        pada sistem EV Charging.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                </main>

            </div>

        </div>

    </div>



    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    <script>

        // Ambil data user dari localStorage
        const userData = localStorage.getItem('user');


        // Jika belum login
        if (!userData) {

            window.location.href = '/admin/login';

        }


        else {

            const user = JSON.parse(userData);


            // Ambil nama admin dari:
            // user -> admin -> nm_admin
            const nmAdmin =
                user.admin?.nm_admin || 'Admin';


            // Tampilkan nama di welcome
            document.getElementById('namaAdmin').textContent =
                nmAdmin;


            // Tampilkan nama di navbar
            document.getElementById('navbarName').textContent =
                nmAdmin;


            // Tampilkan nama di profil
            document.getElementById('profileName').textContent =
                nmAdmin;


            // Tampilkan email
            if (user.email) {

                document.getElementById('profileEmail').textContent =
                    user.email;

            }


            // Tampilkan username
            if (user.identifier) {

                document.getElementById('profileUsername').textContent =
                    user.identifier;

            }

        }


        // Logout
        function logout() {

            localStorage.removeItem('token');

            localStorage.removeItem('user');

            window.location.href =
                '/admin/login';

        }

    </script>


</body>

</html>