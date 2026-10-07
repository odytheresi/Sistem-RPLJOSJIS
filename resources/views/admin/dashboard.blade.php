<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>
        #sidebar {
            width: 220px;
        }

        .sidebar-link {
            color: #adb5bd;
            border-radius: .5rem;
            cursor: pointer;
            transition: .2s;
        }

        .sidebar-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .08);
        }

        .sidebar-link.active {
            color: #fff;
            background: #198754;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        @media (min-width: 992px) {
            #sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                transform: none !important;
                visibility: visible !important;
            }

            .content {
                margin-left: 220px;
            }
        }
    </style>
</head>

<body class="bg-light">

<!-- ========================================================= -->
<!-- SIDEBAR -->
<!-- ========================================================= -->

<div
    class="offcanvas offcanvas-start bg-dark text-white"
    tabindex="-1"
    id="sidebar"
    aria-labelledby="sidebarLabel"
>

    <div class="offcanvas-header border-bottom border-secondary">

        <div>

            <h5
                class="offcanvas-title fw-bold"
                id="sidebarLabel"
            >
                EV ChargeHub
            </h5>

            <small class="text-secondary">
                Admin Panel
            </small>

        </div>

        <button
            type="button"
            class="btn-close btn-close-white d-lg-none"
            data-bs-dismiss="offcanvas"
        ></button>

    </div>


    <div class="offcanvas-body p-3">

        <!-- MENU -->
        <div
            id="menu"
            class="d-grid gap-2"
        ></div>


        <!-- NO ACCESS -->
        <div
            id="noAccess"
            class="alert alert-warning d-none mt-3 small"
        >
            Anda tidak memiliki hak akses ke menu admin.
        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- MAIN CONTENT -->
<!-- ========================================================= -->

<div class="content">


    <!-- ===================================================== -->
    <!-- TOPBAR -->
    <!-- ===================================================== -->

    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">

        <div class="container-fluid">


            <!-- BUTTON MOBILE SIDEBAR -->

            <button
                class="btn btn-outline-secondary d-lg-none me-2"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebar"
            >
                <i class="bi bi-list"></i>
            </button>


            <!-- PAGE TITLE -->

            <span
                id="pageTitle"
                class="navbar-brand mb-0 h1 fw-bold"
            >
                Home
            </span>


            <!-- ================================================= -->
            <!-- PROFILE ADMIN KANAN ATAS -->
            <!-- ================================================= -->

            <div class="dropdown ms-auto">

                <button
                    class="btn btn-light d-flex align-items-center gap-2 border-0"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >

                    <!-- FOTO / ICON PROFILE -->

                    <div
                        class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 38px; height: 38px;"
                    >
                        <i class="bi bi-person-fill"></i>
                    </div>


                    <!-- NAMA ADMIN -->

                    <div class="text-start d-none d-sm-block">

                        <div
                            id="topUserName"
                            class="fw-semibold"
                        >
                            Admin
                        </div>

                        <small class="text-secondary">
                            Administrator
                        </small>

                    </div>


                    <i class="bi bi-chevron-down small"></i>

                </button>


                <!-- DROPDOWN -->

                <ul
                    class="dropdown-menu dropdown-menu-end shadow-sm"
                >

                    <!-- PROFILE -->

                    <li>

                        <div class="dropdown-header">

                            <div class="fw-semibold">
                                <i class="bi bi-person-circle me-1"></i>
                                <span id="dropdownUserName">
                                    Admin
                                </span>
                            </div>

                            <small class="text-secondary">
                                Administrator
                            </small>

                        </div>

                    </li>


                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <!-- SETTING -->

                    <li>

                        <a
                            class="dropdown-item"
                            href="#"
                            id="btnSetting"
                        >

                            <i class="bi bi-gear me-2"></i>

                            Setting

                        </a>

                    </li>


                    <!-- LOGOUT -->

                    <li>

                        <button
                            type="button"
                            class="dropdown-item text-danger"
                            id="btnLogout"
                        >

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </li>

                </ul>

            </div>

        </div>

    </nav>



    <!-- ===================================================== -->
    <!-- PAGE CONTENT -->
    <!-- ===================================================== -->

    <main class="container-fluid p-4">


        <!-- ================================================= -->
        <!-- RINGKASAN -->
        <!-- ================================================= -->

        <section
            id="page-ringkasan"
            class="page-section"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Dashboard Admin
                </h3>

                <p class="text-secondary mb-0">
                    Selamat datang di sistem administrasi EV ChargeHub.
                </p>

            </div>


            <!-- STAT CARDS -->

            <div class="row g-3 mb-4">


                <!-- TOTAL USER -->

                <div class="col-12 col-md-6 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-secondary mb-1">
                                        Total User
                                    </p>

                                    <h3
                                        id="totalUser"
                                        class="fw-bold mb-0"
                                    >
                                        0
                                    </h3>

                                </div>

                                <div class="text-primary fs-2">
                                    <i class="bi bi-people"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- USER AKTIF -->

                <div class="col-12 col-md-6 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-secondary mb-1">
                                        User Aktif
                                    </p>

                                    <h3
                                        id="userAktif"
                                        class="fw-bold mb-0"
                                    >
                                        0
                                    </h3>

                                </div>

                                <div class="text-success fs-2">
                                    <i class="bi bi-person-check"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- TOTAL ROLE -->

                <div class="col-12 col-md-6 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-secondary mb-1">
                                        Total Role
                                    </p>

                                    <h3
                                        id="totalRole"
                                        class="fw-bold mb-0"
                                    >
                                        0
                                    </h3>

                                </div>

                                <div class="text-warning fs-2">
                                    <i class="bi bi-shield-lock"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- NOTIFIKASI -->

                <div class="col-12 col-md-6 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-secondary mb-1">
                                        Notifikasi
                                    </p>

                                    <h3
                                        id="notifBelumDibaca"
                                        class="fw-bold mb-0"
                                    >
                                        0
                                    </h3>

                                </div>

                                <div class="text-danger fs-2">
                                    <i class="bi bi-bell"></i>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- INFORMATION -->

            <div class="row g-4">


                <!-- USER PER ROLE -->

                <div class="col-12 col-lg-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white fw-bold">
                            User berdasarkan Role
                        </div>

                        <div class="card-body">

                            <div
                                id="userPerRole"
                                class="table-responsive"
                            >

                                <div class="text-secondary">
                                    Memuat data...
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- AKTIVITAS -->

                <div class="col-12 col-lg-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white fw-bold">
                            Aktivitas Terbaru
                        </div>

                        <div class="card-body">

                            <div
                                id="logTerbaru"
                                class="table-responsive"
                            >

                                <div class="text-secondary">
                                    Memuat data...
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- USER -->
        <!-- ================================================= -->

        <section
            id="page-user"
            class="page-section d-none"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Manajemen User
                </h3>

                <p class="text-secondary mb-0">
                    Kelola data pengguna sistem.
                </p>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div
                        id="userTable"
                        class="table-responsive"
                    >

                        <div class="text-secondary">
                            Memuat data...
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- ROLE -->
        <!-- ================================================= -->

        <section
            id="page-role"
            class="page-section d-none"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Role & Hak Akses
                </h3>

                <p class="text-secondary mb-0">
                    Kelola role dan hak akses pengguna.
                </p>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div
                        id="roleTable"
                        class="table-responsive"
                    >

                        <div class="text-secondary">
                            Memuat data...
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- KONFIGURASI -->
        <!-- ================================================= -->

        <section
            id="page-konfigurasi"
            class="page-section d-none"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Konfigurasi Sistem
                </h3>

                <p class="text-secondary mb-0">
                    Kelola konfigurasi sistem.
                </p>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div
                        id="konfigTable"
                        class="table-responsive"
                    >

                        <div class="text-secondary">
                            Memuat data...
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- AUDIT LOG -->
        <!-- ================================================= -->

        <section
            id="page-audit"
            class="page-section d-none"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Audit Log
                </h3>

                <p class="text-secondary mb-0">
                    Riwayat aktivitas pengguna sistem.
                </p>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div
                        id="auditTable"
                        class="table-responsive"
                    >

                        <div class="text-secondary">
                            Memuat data...
                        </div>

                    </div>

                </div>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- NOTIFIKASI -->
        <!-- ================================================= -->

        <section
            id="page-notifikasi"
            class="page-section d-none"
        >

            <div class="mb-4">

                <h3 class="fw-bold mb-1">
                    Notifikasi
                </h3>

                <p class="text-secondary mb-0">
                    Informasi dan notifikasi sistem.
                </p>

            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div
                        id="notifTable"
                        class="table-responsive"
                    >

                        <div class="text-secondary">
                            Memuat data...
                        </div>

                    </div>

                </div>

            </div>

        </section>


    </main>

</div>



<!-- ========================================================= -->
<!-- BOOTSTRAP JS -->
<!-- ========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>



<script>

    // =========================================================
    // HELPER
    // =========================================================

    const $ = (id) =>
        document.getElementById(id);



    // =========================================================
    // AUTHENTICATION
    // =========================================================

    const token =
        localStorage.getItem('token');


    let me = null;


    try {

        me = JSON.parse(
            localStorage.getItem('user')
        );

    } catch (e) {

        me = null;

    }



    // =========================================================
    // ROLE
    // =========================================================

    const roleName =
        typeof me?.role === 'object'
            ? me.role?.nma_role
            : me?.role;



    // =========================================================
    // CEK ADMIN
    // =========================================================

    const authorized =
        !!(
            token &&
            me &&
            me.admin &&
            String(roleName || '').toLowerCase() === 'admin'
        );



    /*
     * Jika belum login atau bukan admin,
     * kembali ke halaman login.
     */

    if (!authorized) {

        localStorage.removeItem('token');

        localStorage.removeItem('user');

        window.location.href =
            '/admin/login';

    }



    // =========================================================
    // API
    // =========================================================

    const API_BASE =
        '/api/admin';



    async function api(
        endpoint,
        options = {}
    ) {

        const response =
            await fetch(
                API_BASE + endpoint,
                {
                    ...options,

                    headers: {

                        'Accept':
                            'application/json',

                        'Content-Type':
                            'application/json',

                        ...(options.headers || {}),

                        'Authorization':
                            'Bearer ' + token

                    }

                }
            );


        if (response.status === 401) {

            localStorage.removeItem(
                'token'
            );

            localStorage.removeItem(
                'user'
            );

            window.location.href =
                '/admin/login';

            throw new Error(
                'Sesi berakhir, silakan login lagi'
            );

        }


        let data = null;


        try {

            data =
                await response.json();

        } catch (e) {

            data = null;

        }


        if (!response.ok) {

            throw new Error(
                data?.message ||
                'Terjadi kesalahan pada server.'
            );

        }


        return data;

    }



    // =========================================================
    // PERMISSION
    // =========================================================

    let perm = {};



    function can(
        fitur,
        aksi
    ) {

        return !!(
            perm?.[fitur]?.[aksi]
        );

    }



    async function muatHakAksesSaya() {

        try {

            const response =
                await fetch(
                    '/api/me/hak-akses',
                    {
                        headers: {

                            'Accept':
                                'application/json',

                            'Authorization':
                                'Bearer ' + token

                        }
                    }
                );


            if (response.status === 401) {

                localStorage.removeItem(
                    'token'
                );

                localStorage.removeItem(
                    'user'
                );

                window.location.href =
                    '/admin/login';

                return;

            }


            const data =
                await response.json();


            const rows =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            perm = {};


            rows.forEach(
                row => {

                    const fitur =
                        row.nm_fitur ||
                        row.fitur ||
                        row.nama_fitur;


                    const aksi =
                        row.aksi ||
                        row.action;


                    if (
                        !fitur ||
                        !aksi
                    ) {
                        return;
                    }


                    if (!perm[fitur]) {

                        perm[fitur] = {};

                    }


                    perm[fitur][aksi] =
                        true;

                }
            );


        } catch (error) {

            console.error(
                'Gagal memuat hak akses:',
                error
            );


            /*
             * Fallback supaya admin
             * tetap dapat membuka dashboard.
             */

            perm = {

                dashboard: {
                    lihat: true
                },

                manajemen_user: {
                    lihat: true
                },

                role_hak_akses: {
                    lihat: true
                },

                konfigurasi_sistem: {
                    lihat: true
                },

                audit_log: {
                    lihat: true
                },

                notifikasi: {
                    lihat: true
                }

            };

        }

    }



    // =========================================================
    // PAGE CONFIGURATION
    // =========================================================

    const pages = [

        {
            id: 'ringkasan',
            label: 'Dashboard',
            icon: 'bi-speedometer2',
            fitur: 'dashboard',
            load: loadRingkasan
        },

        {
            id: 'user',
            label: 'Manajemen user',
            icon: 'bi-people',
            fitur: 'manajemen_user',
            load: loadUser
        },

        {
            id: 'role',
            label: 'Role & hak akses',
            icon: 'bi-shield-lock',
            fitur: 'role_hak_akses',
            load: loadRole
        },

        {
            id: 'konfigurasi',
            label: 'Konfigurasi sistem',
            icon: 'bi-sliders',
            fitur: 'konfigurasi_sistem',
            load: loadKonfig
        },

        {
            id: 'audit',
            label: 'Audit log',
            icon: 'bi-journal-text',
            fitur: 'audit_log',
            load: loadAudit
        },

        {
            id: 'notifikasi',
            label: 'Notifikasi',
            icon: 'bi-bell',
            fitur: 'notifikasi',
            load: loadNotif
        }

    ];



    // =========================================================
    // SHOW PAGE
    // =========================================================

    async function showPage(id) {

        const page =
            pages.find(
                p => p.id === id
            );


        if (!page) {
            return;
        }


        document
            .querySelectorAll(
                '.page-section'
            )
            .forEach(
                section => {

                    section.classList.add(
                        'd-none'
                    );

                }
            );


        const target =
            $('page-' + id);


        if (target) {

            target.classList.remove(
                'd-none'
            );

        }


        $('pageTitle').textContent =
            page.label;


        document
            .querySelectorAll(
                '.sidebar-link'
            )
            .forEach(
                link => {

                    link.classList.toggle(
                        'active',
                        link.dataset.page === id
                    );

                }
            );


        history.replaceState(
            null,
            '',
            '#' + id
        );


        try {

            if (
                typeof page.load ===
                'function'
            ) {

                await page.load();

            }

        } catch (error) {

            console.error(
                error
            );

            showError(
                target,
                error.message
            );

        }


        const sidebar =
            document.getElementById(
                'sidebar'
            );


        if (
            window.innerWidth < 992
        ) {

            const instance =
                bootstrap.Offcanvas.getInstance(
                    sidebar
                );


            if (instance) {
                instance.hide();
            }

        }

    }



    // =========================================================
    // RINGKASAN
    // =========================================================

    async function loadRingkasan() {

        try {

            const data =
                await api('/ringkasan');


            $('totalUser').textContent =
                data.total_user ?? 0;


            $('userAktif').textContent =
                data.user_aktif ?? 0;


            $('totalRole').textContent =
                data.total_role ?? 0;


            $('notifBelumDibaca').textContent =
                data.notif_belum_dibaca ?? 0;



            const userPerRole =
                data.user_per_role || [];


            if (
                !userPerRole.length
            ) {

                $('userPerRole').innerHTML =
                    '<div class="text-secondary">Belum ada data.</div>';

            } else {

                $('userPerRole').innerHTML = `

                    <table class="table table-hover mb-0">

                        <thead>

                            <tr>

                                <th>
                                    Role
                                </th>

                                <th class="text-end">
                                    Jumlah
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            ${userPerRole.map(
                                item => `

                                <tr>

                                    <td>
                                        ${escapeHtml(
                                            item.role ||
                                            item.nma_role ||
                                            '-'
                                        )}
                                    </td>

                                    <td class="text-end">
                                        ${item.total ?? 0}
                                    </td>

                                </tr>

                            `).join('')}

                        </tbody>

                    </table>

                `;

            }



            const logs =
                data.log_terbaru || [];


            if (!logs.length) {

                $('logTerbaru').innerHTML =
                    '<div class="text-secondary">Belum ada aktivitas.</div>';

            } else {

                $('logTerbaru').innerHTML = `

                    <table class="table table-hover mb-0">

                        <thead>

                            <tr>

                                <th>
                                    Aktivitas
                                </th>

                                <th>
                                    Waktu
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            ${logs.map(
                                log => `

                                <tr>

                                    <td>
                                        ${escapeHtml(
                                            log.aktivitas || '-'
                                        )}
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            log.created_at || '-'
                                        )}
                                    </td>

                                </tr>

                            `).join('')}

                        </tbody>

                    </table>

                `;

            }


        } catch (error) {

            console.error(
                'Ringkasan:',
                error
            );


            $('userPerRole').innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat data:
                    ${escapeHtml(error.message)}
                </div>
                `;


            $('logTerbaru').innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat data:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // USER
    // =========================================================

    async function loadUser() {

        const container =
            $('userTable');


        try {

            const data =
                await api('/user');


            const users =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            if (!users.length) {

                container.innerHTML =
                    '<div class="text-secondary">Belum ada data user.</div>';

                return;

            }


            container.innerHTML = `

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Identifier
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${users.map(
                            u => {

                                const role =
                                    typeof u.role === 'object'
                                        ? u.role?.nma_role
                                        : u.role;


                                return `

                                    <tr>

                                        <td>
                                            ${escapeHtml(
                                                u.id_user ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                u.identifier ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                u.email ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${escapeHtml(
                                                role ?? '-'
                                            )}
                                        </td>

                                        <td>
                                            ${statusBadge(
                                                u.status
                                            )}
                                        </td>

                                    </tr>

                                `;

                            }
                        ).join('')}

                    </tbody>

                </table>

            `;


        } catch (error) {

            container.innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat user:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // ROLE
    // =========================================================

    async function loadRole() {

        const container =
            $('roleTable');


        try {

            const data =
                await api('/role');


            const roles =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            if (!roles.length) {

                container.innerHTML =
                    '<div class="text-secondary">Belum ada data role.</div>';

                return;

            }


            container.innerHTML = `

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>
                                ID Role
                            </th>

                            <th>
                                Nama Role
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${roles.map(
                            role => `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        role.id_role ?? '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        role.nma_role ?? '-'
                                    )}
                                </td>

                                <td>
                                    ${statusBadge(
                                        role.status
                                    )}
                                </td>

                            </tr>

                        `).join('')}

                    </tbody>

                </table>

            `;


        } catch (error) {

            container.innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat role:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // KONFIGURASI
    // =========================================================

    async function loadKonfig() {

        const container =
            $('konfigTable');


        try {

            const data =
                await api('/konfigurasi');


            const rows =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            if (!rows.length) {

                container.innerHTML =
                    '<div class="text-secondary">Belum ada konfigurasi.</div>';

                return;

            }


            container.innerHTML = `

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>
                                Nama
                            </th>

                            <th>
                                Nilai
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${rows.map(
                            item => `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        item.nama ||
                                        item.nm_konfigurasi ||
                                        item.key ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        item.nilai ||
                                        item.value ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${statusBadge(
                                        item.status
                                    )}
                                </td>

                            </tr>

                        `).join('')}

                    </tbody>

                </table>

            `;


        } catch (error) {

            container.innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat konfigurasi:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // AUDIT
    // =========================================================

    async function loadAudit() {

        const container =
            $('auditTable');


        try {

            const data =
                await api('/audit-log');


            const logs =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            if (!logs.length) {

                container.innerHTML =
                    '<div class="text-secondary">Belum ada audit log.</div>';

                return;

            }


            container.innerHTML = `

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>
                                User
                            </th>

                            <th>
                                Aktivitas
                            </th>

                            <th>
                                Entitas
                            </th>

                            <th>
                                Waktu
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${logs.map(
                            log => `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        log.user?.identifier ||
                                        log.identifier ||
                                        log.user_id ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.aktivitas ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.entitas_terkait ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        log.created_at ||
                                        '-'
                                    )}
                                </td>

                            </tr>

                        `).join('')}

                    </tbody>

                </table>

            `;


        } catch (error) {

            container.innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat audit log:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // NOTIFIKASI
    // =========================================================

    async function loadNotif() {

        const container =
            $('notifTable');


        try {

            const data =
                await api('/notifikasi');


            const notifications =
                Array.isArray(data)
                    ? data
                    : (
                        Array.isArray(data?.data)
                            ? data.data
                            : []
                    );


            if (!notifications.length) {

                container.innerHTML =
                    '<div class="text-secondary">Tidak ada notifikasi.</div>';

                return;

            }


            container.innerHTML = `

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>
                                Judul
                            </th>

                            <th>
                                Pesan
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Waktu
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        ${notifications.map(
                            notif => `

                            <tr>

                                <td>
                                    ${escapeHtml(
                                        notif.judul ||
                                        notif.title ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        notif.pesan ||
                                        notif.message ||
                                        '-'
                                    )}
                                </td>

                                <td>
                                    ${statusBadge(
                                        notif.status
                                    )}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        notif.created_at ||
                                        '-'
                                    )}
                                </td>

                            </tr>

                        `).join('')}

                    </tbody>

                </table>

            `;


        } catch (error) {

            container.innerHTML =
                `
                <div class="text-danger">
                    Gagal memuat notifikasi:
                    ${escapeHtml(error.message)}
                </div>
                `;

        }

    }



    // =========================================================
    // STATUS BADGE
    // =========================================================

    function statusBadge(status) {

        if (!status) {
            return '-';
        }


        const value =
            String(status).toLowerCase();


        let cls =
            'bg-secondary';


        if (
            value === 'aktif' ||
            value === 'active' ||
            value === 'dibaca'
        ) {

            cls =
                'bg-success';

        }


        if (
            value === 'nonaktif' ||
            value === 'inactive'
        ) {

            cls =
                'bg-danger';

        }


        if (
            value === 'belum dibaca' ||
            value === 'unread'
        ) {

            cls =
                'bg-warning text-dark';

        }


        return `
            <span class="badge ${cls}">
                ${escapeHtml(status)}
            </span>
        `;

    }



    // =========================================================
    // ESCAPE HTML
    // =========================================================

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }


        return String(value)
            .replaceAll(
                '&',
                '&amp;'
            )
            .replaceAll(
                '<',
                '&lt;'
            )
            .replaceAll(
                '>',
                '&gt;'
            )
            .replaceAll(
                '"',
                '&quot;'
            )
            .replaceAll(
                "'",
                '&#039;'
            );

    }



    // =========================================================
    // ERROR
    // =========================================================

    function showError(
        target,
        message
    ) {

        if (!target) {
            return;
        }


        target.innerHTML = `

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle me-2"></i>

                ${escapeHtml(message)}

            </div>

        `;

    }



    // =========================================================
    // INIT
    // =========================================================

    async function init() {


        /*
         * Ambil nama admin dari database.
         *
         * Prioritas:
         * 1. nm_admin
         * 2. identifier
         * 3. Admin
         */

        const nmAdmin =
            me?.admin?.nm_admin ||
            me?.identifier ||
            'Admin';


        /*
         * Tampilkan nama di kanan atas
         */

        $('topUserName').textContent =
            nmAdmin;


        /*
         * Tampilkan nama juga
         * di dropdown profile
         */

        $('dropdownUserName').textContent =
            nmAdmin;


        /*
         * Muat hak akses
         */

        await muatHakAksesSaya();


        /*
         * Filter menu berdasarkan permission
         */

        const boleh =
            pages.filter(
                p =>
                    can(
                        p.fitur,
                        'lihat'
                    )
            );


        /*
         * Kalau permission kosong,
         * semua menu ditampilkan.
         */

        const menuPages =
            boleh.length
                ? boleh
                : pages;


        /*
         * Generate sidebar menu
         */

        $('menu').innerHTML =
            menuPages
                .map(
                    page => `

                        <a
                            class="sidebar-link text-decoration-none d-flex align-items-center px-3 py-2"
                            data-page="${page.id}"
                        >

                            <i
                                class="bi ${page.icon} me-2"
                            ></i>

                            <span>
                                ${page.label}
                            </span>

                        </a>

                    `
                )
                .join('');


        /*
         * Event klik menu
         */

        document
            .querySelectorAll(
                '.sidebar-link'
            )
            .forEach(
                link => {

                    link.addEventListener(
                        'click',
                        () => {

                            showPage(
                                link.dataset.page
                            );

                        }
                    );

                }
            );


        /*
         * Cek hash URL
         */

        const awal =
            location.hash.replace(
                '#',
                ''
            );


        /*
         * Tentukan halaman awal
         */

        const halamanAwal =
            menuPages.some(
                p =>
                    p.id === awal
            )
                ? awal
                : menuPages[0].id;


        /*
         * Tampilkan halaman
         */

        await showPage(
            halamanAwal
        );

    }



    // =========================================================
    // SETTING
    // =========================================================

    $('btnSetting').addEventListener(
        'click',
        function (event) {

            event.preventDefault();

            /*
             * Untuk sementara Setting belum
             * diarahkan ke halaman baru.
             *
             * Nanti bisa diarahkan ke:
             * /admin/setting
             */

            alert(
                'Halaman Setting belum tersedia.'
            );

        }
    );



    // =========================================================
    // LOGOUT
    // =========================================================

    $('btnLogout').addEventListener(
        'click',
        async () => {

            try {

                await fetch(
                    '/api/logout',
                    {
                        method: 'POST',

                        headers: {

                            'Accept':
                                'application/json',

                            'Authorization':
                                'Bearer ' + token

                        }

                    }
                );

            } catch (error) {

                console.error(
                    'Logout API:',
                    error
                );

            } finally {

                /*
                 * Hapus session browser
                 */

                localStorage.removeItem(
                    'token'
                );

                localStorage.removeItem(
                    'user'
                );


                /*
                 * Kembali ke login
                 */

                window.location.href =
                    '/admin/login';

            }

        }
    );

    // =========================================================
    // START
    // =========================================================

    init();

</script>

</body>
</html>