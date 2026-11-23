<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EV ChargeHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Palet: Persimmon #E1932C | Cornsilk #F0DF87 | Glacier #A0CED9 | Malachite #3D9E71 | Deep Atlantic #133968 */
        :root {
            --persimmon: #E1932C;
            --cornsilk:  #F0DF87;
            --glacier:   #A0CED9;
            --malachite: #3D9E71;
            --atlantic:  #133968;
            --page-bg:   #FBF6DC; /* Cornsilk versi lembut. Ganti ke #F0DF87 kalau mau yang pekat */

            --bs-success: #3D9E71; --bs-success-rgb: 61, 158, 113;
            --bs-danger:  #E1932C; --bs-danger-rgb: 225, 147, 44;
            --bs-warning: #E1932C; --bs-warning-rgb: 225, 147, 44;
            --bs-primary: #133968; --bs-primary-rgb: 19, 57, 104;
            --bs-dark:    #133968; --bs-dark-rgb: 19, 57, 104;
        }

        body { background: var(--page-bg); }

        /* ===== Sidebar ===== */
        #sidebar { width: 240px; }
        #sidebar .offcanvas-header { border-color: rgba(160,206,217,.25) !important; }
        #sidebar .brand-icon {
            width: 40px; height: 40px; border-radius: .75rem;
            background: var(--malachite); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: .6rem;
            padding: .6rem .9rem;
            color: var(--glacier); border-radius: .6rem;
            text-decoration: none; transition: .2s;
        }
        .sidebar-link:hover { color: #fff; background: rgba(160,206,217,.18); }
        .sidebar-link.active { color: #fff; background: var(--malachite); font-weight: 600; }
        .sidebar-promo {
            background: rgba(160,206,217,.15);
            border: 1px solid rgba(160,206,217,.25);
            border-radius: .9rem;
        }

        @media (min-width: 992px) {
            #sidebar { position: fixed; top: 0; bottom: 0; left: 0; transform: none !important; visibility: visible !important; }
            .content { margin-left: 240px; }
        }

        /* ===== Topbar ===== */
        .topbar { background: #fff; border-bottom: 1px solid #e6e2c8; }
        .date-chip {
            background: var(--page-bg); color: var(--atlantic);
            border-radius: .6rem; padding: .4rem .8rem; font-weight: 500;
        }
        .avatar { width: 38px; height: 38px; background: var(--malachite); }

        /* ===== Judul halaman ===== */
        .page-title { color: var(--atlantic); font-weight: 700; }

        /* ===== Card & tabel ala dashboard ===== */
        .card { border-radius: 1rem; }
        .card-header { border-bottom: 1px solid #eef3f5; color: var(--atlantic); border-radius: 1rem 1rem 0 0 !important; }
        .table { --bs-table-hover-bg: #F3F9FB; }
        .table thead th {
            background: #E6F3F6; color: var(--atlantic);
            font-size: .8rem; font-weight: 600; white-space: nowrap; border-bottom: 0;
        }
        .table thead th:first-child { border-top-left-radius: .6rem; }
        .table thead th:last-child  { border-top-right-radius: .6rem; }
        .table td, .table th { vertical-align: middle; }

        /* ===== Ikon kartu statistik ===== */
        .stat-icon {
            width: 52px; height: 52px; border-radius: .9rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .ic-1 { background: rgba(19,57,104,.12);  color: var(--atlantic); }
        .ic-2 { background: rgba(61,158,113,.15); color: var(--malachite); }
        .ic-3 { background: rgba(225,147,44,.15); color: var(--persimmon); }
        .ic-4 { background: rgba(160,206,217,.35); color: var(--atlantic); }

        /* ===== Badge status ===== */
        .badge { border-radius: 999px; padding: .45em .8em; font-weight: 600; }

        /* ===== Tombol ===== */
        .btn-success {
            --bs-btn-bg: #3D9E71; --bs-btn-border-color: #3D9E71; --bs-btn-color: #fff;
            --bs-btn-hover-bg: #133968; --bs-btn-hover-border-color: #133968; --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #133968; --bs-btn-active-border-color: #133968;
            --bs-btn-disabled-bg: #3D9E71; --bs-btn-disabled-border-color: #3D9E71;
            --bs-btn-focus-shadow-rgb: 61,158,113;
        }
        .btn-outline-success {
            --bs-btn-color: #3D9E71; --bs-btn-border-color: #3D9E71;
            --bs-btn-hover-bg: #3D9E71; --bs-btn-hover-border-color: #3D9E71; --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #3D9E71; --bs-btn-active-border-color: #3D9E71;
            --bs-btn-focus-shadow-rgb: 61,158,113;
        }
        .btn-outline-primary {
            --bs-btn-color: #133968; --bs-btn-border-color: #133968;
            --bs-btn-hover-bg: #133968; --bs-btn-hover-border-color: #133968; --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #133968; --bs-btn-active-border-color: #133968;
        }
        .btn-outline-danger {
            --bs-btn-color: #E1932C; --bs-btn-border-color: #E1932C;
            --bs-btn-hover-bg: #E1932C; --bs-btn-hover-border-color: #E1932C; --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #E1932C; --bs-btn-active-border-color: #E1932C;
        }
        .btn-danger { --bs-btn-bg: #E1932C; --bs-btn-border-color: #E1932C; --bs-btn-hover-bg: #c27d20; --bs-btn-hover-border-color: #c27d20; }

        .form-control:focus, .form-select:focus, .form-check-input:focus {
            border-color: #3D9E71; box-shadow: 0 0 0 .25rem rgba(61,158,113,.25);
        }
        .form-check-input:checked { background-color: #3D9E71; border-color: #3D9E71; }
        .modal-header { background: #E6F3F6; color: var(--atlantic); }
    </style>
</head>

<body data-menu="@yield('menu')">

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar">
    <div class="offcanvas-header border-bottom">
        <div class="d-flex align-items-center gap-2">
            <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <div>
                <h5 class="offcanvas-title fw-bold mb-0">EV ChargeHub</h5>
                <small style="color: var(--glacier)">Admin Panel</small>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3 d-flex flex-column">
        <div id="menu" class="d-grid gap-2"></div>

        <div class="sidebar-promo p-3 mt-auto">
            <div class="fw-semibold mb-1"><i class="bi bi-lightning-charge-fill me-1" style="color: var(--cornsilk)"></i>EV ChargeHub</div>
            <small style="color: var(--glacier)">Kelola pengguna, role, dan aktivitas sistem charging dengan mudah.</small>
        </div>
    </div>
</div>

<div class="content">

    <nav class="navbar topbar sticky-top">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary d-lg-none me-2" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>

            <span class="date-chip d-none d-sm-inline-block">
                <i class="bi bi-calendar3 me-2"></i><span id="tglSekarang"></span>
            </span>

            <script>
                // Logout otomatis setelah 15 menit tanpa aktivitas
                (function () {
                    const batas = 15 * 60 * 1000;
                    let timer;

                    function keluar() {
                        localStorage.removeItem('token');
                        localStorage.removeItem('user');
                        window.location.href = '/login';
                    }

                    function reset() {
                        clearTimeout(timer);
                        timer = setTimeout(keluar, batas);
                    }

                    ['click', 'keydown', 'mousemove', 'scroll'].forEach(e =>
                        document.addEventListener(e, reset));
                    reset();
                })();
             </script>

            <div class="dropdown ms-auto">
                <button class="btn btn-light d-flex align-items-center gap-2 border-0 bg-transparent" type="button"
                        data-bs-toggle="dropdown">
                    <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <div id="topUserName" class="fw-semibold">Admin</div>
                        <small class="text-secondary">Administrator</small>
                    </div>
                    <i class="bi bi-chevron-down small"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li class="dropdown-header">
                        <div class="fw-semibold">
                            <i class="bi bi-person-circle me-1"></i><span id="dropdownUserName">Admin</span>
                        </div>
                        <small class="text-secondary">Administrator</small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item text-danger" id="btnLogout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid p-4">
        <div id="konten">
            <h2 class="page-title mb-1">@yield('title')</h2>
            <p class="text-secondary mb-4">@yield('subtitle')</p>
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
<script>
    document.getElementById('tglSekarang').textContent =
        new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
</script>
@yield('scripts')

</body>
</html>
