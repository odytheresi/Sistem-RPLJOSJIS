```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - EVChargeHub</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --navy: #101c36;
            --blue: #3867f4;
            --bg: #f4f7fc;
            --text: #18243b;
            --muted: #8290a7;
            --border: #e9edf5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
        }

        .app-shell { min-height: 100vh; }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            padding: 28px 18px;
            background: var(--navy);
            color: white;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 30px;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            border-radius: 13px;
            background: var(--blue);
            font-size: 23px;
        }

        .brand strong { display: block; font-size: 17px; }
        .brand small { color: #9aa9c5; font-size: 11px; }

        .nav-label {
            padding: 12px 12px 9px;
            color: #71809e;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.3px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 5px;
            padding: 12px 13px;
            color: #b9c5da;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: .2s;
        }

        .sidebar nav a i { font-size: 17px; }
        .sidebar nav a:hover { background: #1b2b4b; color: white; }

        .sidebar nav a.active {
            background: var(--blue);
            color: white;
            box-shadow: 0 7px 18px #3867f440;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 18px 10px 0;
            border-top: 1px solid #293652;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: #26395c;
            color: #dbe7ff;
            font-weight: 800;
        }

        .user-name {
            min-width: 0;
            color: white;
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .user-role { color: #91a0bb; font-size: 11px; }

        .logout-button {
            margin-top: 16px;
            width: 100%;
            padding: 10px;
            border: 1px solid #34425e;
            border-radius: 9px;
            background: transparent;
            color: #d5deed;
        }

        .logout-button:hover { background: #263653; }

        .main-area {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 76px;
            padding: 0 34px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .breadcrumb-text { color: var(--muted); font-size: 12px; }
        .topbar h1 { margin: 3px 0 0; font-size: 19px; font-weight: 800; }

        .today {
            padding: 10px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: #66748c;
            font-size: 12px;
        }

        .page-content { max-width: 1500px; margin: auto; padding: 30px 34px 45px; }

        .alert { border-radius: 12px; }

        /* Gaya umum untuk komponen dashboard */
        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .page-heading h2 { margin: 0 0 7px; font-size: 25px; font-weight: 800; }
        .page-heading p { margin: 0; color: var(--muted); }

        .btn-primary {
            background: var(--blue);
            border-color: var(--blue);
            border-radius: 9px;
            padding: 10px 15px;
            font-weight: 700;
        }

        .btn-primary:hover { background: #2853dc; border-color: #2853dc; }

        .stat-card {
            height: 100%;
            padding: 22px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 5px 20px #172c4d05;
        }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 45px;
            height: 45px;
            border-radius: 13px;
            font-size: 21px;
        }

        .stat-label { margin-top: 19px; color: var(--muted); font-size: 12px; font-weight: 600; }
        .stat-value { margin-top: 4px; font-size: 29px; font-weight: 800; }
        .stat-note { margin-top: 5px; color: var(--muted); font-size: 11px; }

        .panel {
            height: 100%;
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }

        .panel-header {
            padding: 20px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h3 { margin: 0; font-size: 15px; font-weight: 800; }
        .panel-body { padding: 22px; }

        .table { margin: 0; vertical-align: middle; }
        .table thead th {
            padding: 13px 16px;
            background: #f8faff;
            color: #7b89a0;
            font-size: 10px;
            letter-spacing: .6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td { padding: 15px 16px; border-color: #edf0f6; }
        .table-responsive { overflow-x: auto; }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 16px;
            color: var(--text);
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            text-decoration: none;
            transition: .2s;
        }

        .quick-link:hover {
            transform: translateY(-2px);
            border-color: #b9caff;
            box-shadow: 0 8px 20px #172c4d0a;
            color: var(--blue);
        }

        .quick-link i { font-size: 22px; color: var(--blue); }
        .quick-link strong { display: block; font-size: 12px; }
        .quick-link small { color: var(--muted); font-size: 11px; }

        @media (max-width: 900px) {
            .sidebar { width: 205px; }
            .main-area { margin-left: 205px; }
            .topbar { padding: 0 20px; }
            .page-content { padding: 22px 20px; }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                padding: 15px;
            }

            .brand { padding-bottom: 12px; }
            .sidebar nav { display: flex; flex-wrap: wrap; }
            .nav-label, .sidebar-bottom { display: none; }
            .sidebar nav a { padding: 9px 10px; font-size: 12px; }
            .main-area { margin-left: 0; }
            .topbar { height: auto; padding: 17px; }
            .today { display: none; }
            .page-content { padding: 20px 14px; }
            .page-heading h2 { font-size: 21px; }
        }
    </style>

    @stack('styles')
</head>
<body>
    @php
        $operator = auth()->user()?->operator;
        $nama = $operator->nama_operator ?? auth()->user()?->name ?? 'Operator';
    @endphp

    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <div>
                    <strong>EVChargeHub</strong>
                    <small>Operator Workspace</small>
                </div>
            </div>

            <div class="nav-label">MENU UTAMA</div>
            <nav>
                <a href="{{ route('operator.dashboard') }}"
                   class="{{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a href="{{ route('operator.station.index') }}"
                   class="{{ request()->routeIs('operator.station.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i> Stasiun
                </a>
                <a href="{{ route('operator.charger.index') }}"
                   class="{{ request()->routeIs('operator.charger.*') ? 'active' : '' }}">
                    <i class="bi bi-plug-fill"></i> Data Charger
                </a>
                <a href="{{ route('operator.tarif.index') }}"
                   class="{{ request()->routeIs('operator.tarif.*') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar"></i> Pengaturan Tarif
                </a>
                <a href="{{ route('operator.keluhan.index') }}"
                   class="{{ request()->routeIs('operator.keluhan.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text-fill"></i> Keluhan
                </a>
                <a href="{{ route('operator.perbaikan.index') }}"
                   class="{{ request()->routeIs('operator.perbaikan.*') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i> Maintenance
                </a>
            </nav>

            <div class="sidebar-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="user-avatar">
                        {{ strtoupper(substr($nama, 0, 1)) }}
                    </div>
                    <div class="user-name">
                        {{ $nama }}
                        <div class="user-role">Administrator Operator</div>
                    </div>
                </div>

                @if (Route::has('logout'))
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="logout-button" type="submit">
                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                        </button>
                    </form>
                @endif
            </div>
        </aside>

        <div class="main-area">
            <header class="topbar">
                <div>
                    <div class="breadcrumb-text">EVChargeHub / Panel Operator</div>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
                <div class="today">
                    <i class="bi bi-calendar3 me-2"></i>
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </div>
            </header>

            <main class="page-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```