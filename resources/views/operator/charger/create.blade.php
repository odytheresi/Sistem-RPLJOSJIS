<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Charger - EVChargeHub</title>
    <style>
    :root { --green: #3d9e71; --green-dark: #2f7d59; --green-soft: #e0f1e8; --text: #172033; --muted: #8390a5; --line: #e7ecf3; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f7fb; color: var(--text); display: flex; min-height: 100vh; font-size: 14px; }
    a { color: var(--green); text-decoration: none; }

    .sidebar { width: 240px; background: linear-gradient(180deg, #3d9e71, #2a7352); color: #fff; padding: 24px 16px; flex-shrink: 0; }
    .sidebar h1 { font-size: 18px; margin-bottom: 4px; }
    .sidebar .subtitle { font-size: 12px; color: #d4eee1; margin-bottom: 32px; }
    .sidebar nav a { display: block; color: #e6f5ed; padding: 12px 14px; border-radius: 10px; margin-bottom: 10px; font-size: 14px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18); transition: background .2s, transform .2s; }
    .sidebar nav a:hover { background: rgba(255,255,255,.2); color: #fff; transform: translateX(3px); }
    .sidebar nav a.active { background: rgba(255,255,255,.28); border-color: rgba(255,255,255,.5); color: #fff; font-weight: 700; }

    .main { flex: 1; padding: 28px 32px; overflow-x: auto; min-width: 0; }
    .topbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
    .topbar h2 { font-size: 22px; font-weight: 800; }
    .topbar p { color: var(--muted); font-size: 12px; margin-top: 5px; }
    .section-title { font-size: 16px; font-weight: 800; margin: 0; }
    .section-subtitle { color: var(--muted); font-size: 12px; margin-top: 5px; }

    .btn { display: inline-block; padding: 9px 16px; border-radius: 9px; border: 1px solid transparent; font-size: 12px; font-weight: 700;
        font-family: inherit; cursor: pointer; background: var(--green); color: #fff; transition: .2s; }
    .btn:hover { background: var(--green-dark); transform: translateY(-2px); color: #fff; }
    .btn-light { background: #fff; color: var(--text); border-color: var(--line); }
    .btn-light:hover { background: #f1f5f9; color: var(--text); }

    .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 13px; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #b91c1c; }
    .alert ul { margin: 6px 0 0 18px; }

    .dashboard-panel { background: #fff; border: 1px solid var(--line); border-radius: 15px; overflow: hidden; margin-bottom: 22px; max-width: 820px; }
    .panel-header { padding: 20px 22px; display: flex; align-items: center; justify-content: space-between; gap: 12px; border-bottom: 1px solid #edf0f5; flex-wrap: wrap; }
    .panel-body { padding: 20px 22px; }
    .empty { text-align: center; color: #98a2b3; padding: 28px; font-size: 13px; }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-weight: 700; font-size: 12px; color: #475569; }
    .form-control { padding: 11px 13px; border: 1px solid var(--line); border-radius: 10px; font-size: 13px; font-family: inherit;
        background: #fff; color: var(--text); outline: none; transition: .2s; width: 100%; }
    .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 3px #3d9e7122; }
    .form-control.is-invalid { border-color: #dc2626; }
    .form-control:disabled { background: #f8fafc; color: #98a2b3; }
    .field-error { color: #b91c1c; font-size: 11px; }
    .hint { color: #98a2b3; font-size: 11px; }
    .form-actions { display: flex; gap: 10px; margin-top: 8px; }
    .form-section { border-top: 1px dashed var(--line); padding-top: 18px; margin-bottom: 20px; }
    .form-section-title { font-size: 14px; font-weight: 800; margin-bottom: 6px; }

    @media (max-width: 900px) { body { flex-direction: column; } .sidebar { width: 100%; } .main { padding: 22px 18px; } }
    @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>
    <aside class="sidebar">
        <h1>⚡ EVChargeHub</h1>
        <div class="subtitle">Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">📊 Dashboard</a>
            <a href="{{ url('/operator/lokasi_stasiun') }}">📍 Lokasi Stasiun</a>
            <a href="{{ route('operator.charger.index') }}" class="active">🔌 Charger</a>
            <a href="{{ url('/operator/keluhan') }}">📝 Keluhan</a>
            <a href="{{ url('/operator/maintenance') }}">📈 Maintenance</a>
        </nav>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h2>Tambah Charger</h2>
                <p>Daftarkan unit charger baru beserta tarif pengisiannya.</p>
            </div>
            <a href="{{ route('operator.charger.index') }}" class="btn btn-light">← Kembali</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                Periksa kembali isian Anda:
                <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <section class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3 class="section-title">Form Charger Baru</h3>
                    <div class="section-subtitle">Lengkapi data charger dan tarif di bawah ini.</div>
                </div>
            </div>
            <div class="panel-body">
                @if ($stations->isEmpty())
                    <div class="empty">Anda belum memiliki stasiun aktif. Aktifkan stasiun terlebih dahulu.</div>
                @else
                    @include('operator.charger.form', [
                        'action'      => route('operator.charger.store'),
                        'submitLabel' => 'Simpan',
                    ])
                @endif
            </div>
        </section>
    </main>
</body>
</html>