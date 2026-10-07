<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengemudi</title>

    <style>
        * {
            box-sizing: border-box; /* untuk memastikan padding dan border tidak mempengaruhi lebar elemen */
        }

        body { /* Bagian ini mengatur gaya dasar untuk keseluruh halaman */
            margin: 0;
            font-family: Arial, sans-serif;
            background: #e8e9bb;
            color: #1f2937;/* untuk mengatur warna teks bagian body pada halaman */
            padding-bottom: 80px;
        }

        /* HEADER */
        .header { /* Bagian ini mengatur gaya untuk header halaman */
            background: #0f766e;
            color: white;
            padding: 25px 20px 35px;
            border-radius: 0 0 25px 25px;
        }

        .header-content { /* Bagian ini mengatur gaya untuk konten header */
            max-width: 900px;
            margin: auto;
        }

        .small-text {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 6px;
        }

        .header h1 {
            margin: 0;
            font-size: 25px;
        }

        /* CONTENT */
        .container { /* Bagian ini mengatur gaya untuk konten utama */
            width: 100%;
            max-width: 900px;
            margin: -20px auto 0;
            padding: 0 18px;
            position: relative;
        }

        /* STATUS CARD */
        .status-card { /* Bagian ini mengatur gaya untuk kartu status */
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .status-title {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
        }

        .status-dot {
            width: 11px;
            height: 11px;
            background: #22c55e;
            border-radius: 50%;
        }

        /* MENU */
        .section-title { /* Bagian ini mengatur gaya untuk judul bagian menu */
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0 12px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .menu-card {
            background: white;
            padding: 20px 15px;
            border-radius: 16px;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
            transition: 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-2px);
        }

        .menu-icon {
            width: 45px;
            height: 45px;
            background: #ccfbf1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            margin-bottom: 12px;
        }

        .menu-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .menu-description {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
        }

        /* RECENT ACTIVITY */
        .activity-card {
            background: white;
            padding: 18px;
            border-radius: 16px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .activity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .activity-icon {
            width: 45px;
            height: 45px;
            background: #f0fdfa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .activity-info {
            flex: 1;
        }

        .activity-info strong {
            display: block;
            margin-bottom: 4px;
        }

        .activity-info span {
            font-size: 12px;
            color: #6b7280;
        }

        /* LOGOUT */
        .logout-form {
            margin-top: 25px;
        }

        .logout-button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            background: #dc2626;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background: #b91c1c;
        }

        /* BOTTOM NAVIGATION */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 68px;
            background: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -3px 15px rgba(0, 0, 0, 0.08);
            z-index: 100;
        }

        .nav-item {
            text-decoration: none;
            color: #6b7280;
            font-size: 11px;
            text-align: center;
        }

        .nav-item.active {
            color: #0f766e;
            font-weight: bold;
        }

        .nav-icon {
            display: block;
            font-size: 22px;
            margin-bottom: 3px;
        }

        /* DESKTOP */
        @media (min-width: 768px) {
            body {
                padding-bottom: 30px;
            }
            .header {
                padding: 35px 30px 55px;
            }
            .header h1 {
                font-size: 30px;
            }
            .menu-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            .bottom-nav {
                position: static;
                max-width: 900px;
                margin: 30px auto;
                border-radius: 15px;
                box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            }

            .nav-item {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header">
        <div class="header-content">
            <div class="small-text">Sistem Manajemen Charging EV</div>
            <h1>Hi, Cantik</h1>
        </div>
    </div>

    <div class="container">
        <!-- STATUS -->
        <div class="status-card">
            <div class="status-title">Status akun</div>
            <div class="status">
                <div class="status-dot"></div> Akun Pengemudi Aktif </div>
        </div>

        <!-- MENU UTAMA -->
        <div class="section-title"> Menu Utama </div>
        <div class="menu-grid">
            <a href="#" class="menu-card">
                <div class="menu-icon">⚡</div>
                <div class="menu-title">
                    Charging
                </div>
                <div class="menu-description">
                    Cari dan mulai sesi charging kendaraan.
                </div>
            </a>

            <a href="#" class="menu-card">
                <div class="menu-icon">📍</div>
                <div class="menu-title">
                    Station
                </div>
                <div class="menu-description">
                    Lihat lokasi charging station.
                </div>
            </a>

            <a href="#" class="menu-card">
                <div class="menu-icon">📋</div>
                <div class="menu-title">
                    Riwayat
                </div>
                <div class="menu-description">
                    Lihat riwayat transaksi charging.
                </div>
            </a>

            <a href="{{ route('pengemudi.profile') }}" class="menu-card">
                <div class="menu-icon">👤</div>
                <div class="menu-title"> Profil Saya </div>
                <div class="menu-description">
                    Kelola informasi akun dan kendaraan.
                </div>
            </a>
        </div>

        <!-- AKTIVITAS TERAKHIR -->
        <div class="section-title">
            Aktivitas Terakhir
        </div>
        <div class="activity-card">
            <div class="activity">
                <div class="activity-icon">
                    ⚡
                </div>
                <div class="activity-info">
                    <strong>Belum ada sesi charging</strong>
                    <span>
                        Aktivitas charging kamu akan muncul di sini.
                    </span>
                </div>
            </div>
        </div>

        <!-- LOGOUT -->
        <form action="{{ route('pengemudi.logout') }}"
              method="POST"
              class="logout-form">

            @csrf
            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
            <span class="nav-icon">🏠</span>
            Beranda </a>
        
        <a href="#" class="nav-item">
            <span class="nav-icon">⚡</span>
            Charging </a>
        
        <a href="#" class="nav-item">
            <span class="nav-icon">📋</span>
            Riwayat </a>
        
        <a href="{{ route('pengemudi.profile') }}" class="nav-item">
            <span class="nav-icon">👤</span>
            Profil </a>
    </nav>
</body>
</html>