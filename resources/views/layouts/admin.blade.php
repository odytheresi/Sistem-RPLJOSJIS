<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EV ChargeHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --green: #3d9e71; --green-dark: #2f7d59; --green-soft: #e0f1e8;
            --orange: #E1932C; --navy: #133968;
            --text: #172033; --muted: #8390a5; --line: #e7ecf3;
            --page-bg: #f5f7fb;

            --bs-success: #3D9E71; --bs-success-rgb: 61, 158, 113;
            --bs-danger:  #E1932C; --bs-danger-rgb: 225, 147, 44;
            --bs-warning: #E1932C; --bs-warning-rgb: 225, 147, 44;
            --bs-primary: #133968; --bs-primary-rgb: 19, 57, 104;
            --bs-dark:    #133968; --bs-dark-rgb: 19, 57, 104;
        }

        body { background: var(--page-bg); color: var(--text); font-size: 14px; }

        /* ===== Sidebar (hijau gradasi) ===== */
        #sidebar {
            width: 240px; color: #fff;
            background: linear-gradient(180deg, #3d9e71, #2a7352) !important;
        }
        #sidebar .offcanvas-header { border-color: rgba(255,255,255,.2) !important; }
        #sidebar .brand-icon {
            width: 40px; height: 40px; border-radius: .75rem;
            background: rgba(255,255,255,.22); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
        }
        #sidebar small { color: #d4eee1 !important; }
        .sidebar-link {
            display: flex; align-items: center; gap: .6rem;
            padding: .7rem .9rem; border-radius: 10px;
            color: #e6f5ed; text-decoration: none; font-size: 14px;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
            transition: background .2s, transform .2s;
        }
        .sidebar-link:hover { color: #fff; background: rgba(255,255,255,.2); transform: translateX(3px); }
        .sidebar-link.active {
            color: #fff; font-weight: 700;
            background: rgba(255,255,255,.28); border-color: rgba(255,255,255,.5);
        }
        .sidebar-promo {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 14px; color: #fff;
        }

        @media (min-width: 992px) {
            #sidebar { position: fixed; top: 0; bottom: 0; left: 0; transform: none !important; visibility: visible !important; }
            .content { margin-left: 240px; }
        }

        /* ===== Topbar ===== */
        .topbar { background: transparent; padding: 18px 12px 0; }
        .date-chip {
            background: #fff; color: var(--text); border: 1px solid var(--line);
            border-radius: 999px; padding: .45rem .9rem; font-weight: 600; font-size: 13px;
            box-shadow: 0 4px 16px #16274805;
        }
        .profile-pill {
            background: #fff !important; border: 1px solid var(--line) !important;
            border-radius: 999px !important; padding: 6px 14px !important;
            box-shadow: 0 4px 16px #16274805;
        }
        .profile-pill:hover { border-color: #a6d8bf !important; }
        .avatar { width: 34px; height: 34px; background: var(--green); }

        /* ===== Judul halaman ===== */
        .page-title { color: var(--text); font-weight: 800; font-size: 22px; }

        /* ===== Card & tabel ===== */
        .card {
            border-radius: 15px; background: #fff;
            border: 1px solid var(--line) !important;
            box-shadow: 0 4px 16px #16274805 !important;
        }
        .card-header {
            background: #fff !important; border-bottom: 1px solid #edf0f5;
            color: var(--text); border-radius: 15px 15px 0 0 !important;
        }
        .table { --bs-table-hover-bg: #fafcff; font-size: 13px; }
        .table thead th {
            background: #f8fafc; color: #78869b; font-size: 12px; font-weight: 700;
            white-space: nowrap; border-bottom: 1px solid #edf0f5;
        }
        .table td, .table th { vertical-align: middle; }
        .table td { color: #475569; border-bottom-color: #f0f2f6; }

        /* ===== Ikon kartu statistik ===== */
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;
        }
        .ic-green  { background: var(--green-soft); color: var(--green); }
        .ic-lime   { background: #dcfce7; color: #166534; }
        .ic-orange { background: #ffedd5; color: #c2680a; }
        .ic-red    { background: #fee2e2; color: #b91c1c; }
        .ic-navy   { background: rgba(19,57,104,.12); color: var(--navy); }

        .badge { border-radius: 999px; padding: .45em .8em; font-weight: 700; }

        /* ===== Tombol ===== */
        .btn-success {
            --bs-btn-bg: #3D9E71; --bs-btn-border-color: #3D9E71; --bs-btn-color: #fff;
            --bs-btn-hover-bg: #2f7d59; --bs-btn-hover-border-color: #2f7d59; --bs-btn-hover-color: #fff;
            --bs-btn-active-bg: #2f7d59; --bs-btn-active-border-color: #2f7d59;
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
        .modal-header { background: var(--green-soft); color: var(--text); }
    </style>
    @yield('styles')
</head>

<body data-menu="@yield('menu')">

<div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebar">
    <div class="offcanvas-header border-bottom">
        <div class="d-flex align-items-center gap-2">
            <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <div>
                <h5 class="offcanvas-title fw-bold mb-0">EV ChargeHub</h5>
                <small>Admin Panel</small>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3 d-flex flex-column">
        <div id="menu" class="d-grid gap-2"></div>

        <div class="sidebar-promo p-3 mt-auto">
            <div class="fw-semibold mb-1"><i class="bi bi-lightning-charge-fill me-1"></i>EV ChargeHub</div>
            <small>Kelola pengguna, role, dan aktivitas sistem charging dengan mudah.</small>
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
                <button class="btn d-flex align-items-center gap-2 profile-pill" type="button"
                        data-bs-toggle="dropdown">
                    <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="text-start d-none d-sm-block">
                        <div id="topUserName" class="fw-semibold" style="font-size:13px">Admin</div>
                        <small class="text-secondary" style="font-size:11px">Administrator</small>
                    </div>
                    <i class="bi bi-chevron-down small text-secondary"></i>
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