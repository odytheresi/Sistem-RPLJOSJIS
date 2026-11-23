<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Tarif - EVChargeHub</title>
    <style>
    :root { --green: #3d9e71; --green-dark: #2f7d59; --text: #172033; --muted: #8390a5; --line: #e7ecf3; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; color: var(--text); display: flex; min-height: 100vh; font-size: 14px; }
    a { color: var(--green); text-decoration: none; }

    /* ===== SIDEBAR ===== */
    .sidebar { width: 240px; background: linear-gradient(180deg, #3d9e71, #2a7352); color: #fff; padding: 24px 16px; flex-shrink: 0; }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a {
        display: block; color: #e6f5ed; text-decoration: none; padding: 12px 14px; border-radius: 10px;
        margin-bottom: 10px; font-size: 14px; background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.18); transition: background 0.2s, transform 0.2s;
    }
    .sidebar nav a:hover { background: rgba(255, 255, 255, 0.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active { background: rgba(255, 255, 255, 0.28); border-color: rgba(255, 255, 255, 0.5); color: #fff; font-weight: 700; }

    /* ===== MAIN & TOPBAR ===== */
    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
    .topbar h2 { font-size: 22px; font-weight: 800; color: var(--text); }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .actions form { margin: 0; display: inline; }
    .section-title { font-size: 16px; font-weight: 800; margin: 0; }
    .section-subtitle { color: var(--muted); font-size: 12px; margin-top: 5px; }

    /* ===== BUTTON ===== */
    .btn {
        display: inline-block; padding: 9px 16px; border-radius: 9px; border: 1px solid transparent;
        font-size: 12px; font-weight: 700; font-family: inherit; cursor: pointer;
        background: var(--green); color: #fff; transition: .2s;
    }
    .btn:hover { background: var(--green-dark); transform: translateY(-2px); color: #fff; }
    .btn-light { background: #fff; color: var(--text); border-color: var(--line); }
    .btn-light:hover { background: #f1f5f9; color: var(--text); }
    .btn-warning { background: #f59e0b; color: #fff; }
    .btn-warning:hover { background: #d97706; }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }
    .btn-sm { padding: 6px 11px; font-size: 11px; }

    /* ===== ALERT ===== */
    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }

    /* ===== PANEL & TABLE ===== */
    .dashboard-panel { background: white; border: 1px solid var(--line); border-radius: 15px; overflow: hidden; margin-bottom: 22px; }
    .panel-narrow { max-width: 640px; }
    .panel-header { padding: 20px 22px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border-bottom: 1px solid #edf0f5; flex-wrap: wrap; }
    .panel-body { padding: 20px 22px; }
    .panel-count { padding: 6px 10px; border-radius: 8px; background: #e0f1e8; color: var(--green-dark); font-size: 11px; font-weight: 700; }
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; white-space: nowrap; }
    th { padding: 14px 18px; text-align: left; background: #f8fafc; color: #78869b; font-weight: 700; border-bottom: 1px solid #edf0f5; }
    td { padding: 15px 18px; border-bottom: 1px solid #f0f2f6; color: #475569; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: 0; }
    tbody tr:hover td { background: #fafcff; }
    td strong { color: var(--text); }
    .empty { text-align: center; color: #98a2b3; padding: 28px !important; font-size: 13px; }

    /* ===== FORM ===== */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-group label { font-weight: 700; font-size: 12px; color: #475569; }
    .form-control {
        padding: 11px 13px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px;
        font-family: inherit; background: #fff; color: var(--text); outline: none; transition: .2s; width: 100%;
    }
    .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .form-actions { display: flex; gap: 10px; margin-top: 8px; }

    @media (max-width: 900px) {
        body { flex-direction: column; }
        .sidebar { width: 100%; }
        .main { padding: 22px 18px; }
    }
</style>
</head>
<body>
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}">🔌 Charger</a>
            <a href="{{ route('operator.tarif.index') }}" class="active">💰 Tarif</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Tambah Tarif</h2>
                <p>Tentukan harga pengisian per kWh untuk sebuah charger.</p>
            </div>
            <a class="btn btn-light" href="{{ route('operator.tarif.index') }}">← Kembali</a>
        </div>

        <section class="dashboard-panel panel-narrow">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Form Tarif Baru</h3>
                    <div class="section-subtitle">Lengkapi data tarif di bawah ini.</div>
                </div>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('operator.tarif.store') }}">
                    @csrf
                    @include('operator.tarif.form')
                    <div class="form-actions">
                        <button class="btn" type="submit">Simpan</button>
                        <a class="btn btn-light" href="{{ route('operator.tarif.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>