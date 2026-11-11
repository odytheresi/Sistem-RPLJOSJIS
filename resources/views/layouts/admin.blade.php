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
            --bs-success: #3D9E71; --bs-success-rgb: 61, 158, 113;   /* avatar, hijau   -> Malachite */
            --bs-danger:  #E1932C; --bs-danger-rgb: 225, 147, 44;    /* Logout, merah   -> Persimmon */
            --bs-dark:    #133968; --bs-dark-rgb: 19, 57, 104;       /* sidebar         -> Deep Atlantic */
            --bs-light:   #F0DF87; --bs-light-rgb: 240, 223, 135;    /* latar halaman   -> Cornsilk */
        }

        #sidebar { width: 220px; }
        .sidebar-link { color: #A0CED9; border-radius: .5rem; transition: .2s; }
        .sidebar-link:hover { color: #fff; background: rgba(160, 206, 217, .2); }
        .sidebar-link.active { color: #fff; background: #3D9E71; }
        .table td, .table th { vertical-align: middle; }

        @media (min-width: 992px) {
            #sidebar { position: fixed; top: 0; bottom: 0; left: 0; transform: none !important; visibility: visible !important; }
            .content { margin-left: 220px; }
        }
    </style>

    
</head>

<body class="bg-light" data-menu="@yield('menu')">

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebar">
    <div class="offcanvas-header border-bottom border-secondary">
        <div>
            <h5 class="offcanvas-title fw-bold">EV ChargeHub</h5>
            <small class="text-secondary">Admin Panel</small>
        </div>
        <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3">
        <div id="menu" class="d-grid gap-2"></div>
    </div>
</div>

<div class="content">

    <nav class="navbar bg-white border-bottom sticky-top">
        <div class="container-fluid">
            <button class="btn btn-outline-secondary d-lg-none me-2" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <i class="bi bi-list"></i>
            </button>

            <span class="navbar-brand mb-0 h1 fw-bold">@yield('title')</span>

            <div class="dropdown ms-auto">
                <button class="btn btn-light d-flex align-items-center gap-2 border-0" type="button"
                        data-bs-toggle="dropdown">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 38px; height: 38px;">
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
            <p class="text-secondary mb-4">@yield('subtitle')</p>
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
@yield('scripts')

</body>
</html>