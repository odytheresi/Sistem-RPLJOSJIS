<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Charger</title>
    <style>
        :root{--bg:#f4f6f9;--card:#fff;--text:#1f2937;--muted:#6b7280;--line:#e5e7eb;--primary:#0f766e;--primary-dark:#0b5d57;--green-bg:#dcfce7;--green:#166534;--blue-bg:#dbeafe;--blue:#1d4ed8;--red-bg:#fee2e2;--red:#b91c1c}
        *{box-sizing:border-box}
        body{margin:0;font-family:'Segoe UI',Tahoma,sans-serif;background:var(--bg);color:var(--text);font-size:14px}
        a{color:var(--primary);text-decoration:none}
        .topbar{background:var(--primary);color:#fff;padding:14px 28px;display:flex;justify-content:space-between;align-items:center}
        .topbar .brand{font-weight:700;font-size:16px}
        .topbar nav a{color:#d1fae5;margin-left:18px;font-weight:500}
        .topbar nav a.active,.topbar nav a:hover{color:#fff;text-decoration:underline}
        .container{max-width:1100px;margin:24px auto;padding:0 20px}
        .page-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;gap:12px;flex-wrap:wrap}
        .page-head h1{margin:0;font-size:22px}
        .card{background:var(--card);border:1px solid var(--line);border-radius:10px;padding:20px;margin-bottom:18px}
        .btn{display:inline-block;padding:8px 14px;border-radius:7px;border:1px solid transparent;font-size:13px;font-weight:600;cursor:pointer;background:var(--primary);color:#fff}
        .btn:hover{background:var(--primary-dark)}
        .btn-light{background:#fff;color:var(--text);border-color:var(--line)}
        .btn-light:hover{background:#f3f4f6}
        .alert{padding:11px 14px;border-radius:8px;margin-bottom:16px}
        .alert-success{background:var(--green-bg);color:var(--green)}
        .alert-error{background:var(--red-bg);color:var(--red)}
        .alert ul{margin:6px 0 0 18px;padding:0}
        .badge{display:inline-block;padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700}
        .badge-digunakan{background:var(--blue-bg);color:var(--blue)}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group.full{grid-column:1/-1}
        label{font-weight:600;font-size:13px}
        input,select{padding:9px 11px;border:1px solid var(--line);border-radius:7px;font-size:14px;font-family:inherit;background:#fff}
        input:focus,select:focus{outline:2px solid #99f6e4;border-color:var(--primary)}
        .hint{color:var(--muted);font-size:12px}
        .field-error{color:var(--red);font-size:12px}
        .form-actions{margin-top:20px;display:flex;gap:10px}
        .empty{text-align:center;color:var(--muted);padding:28px}
        @media(max-width:640px){.form-grid{grid-template-columns:1fr}.topbar{flex-direction:column;gap:8px}}
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">⚡ Panel Operator</div>
        <nav>
            <a href="{{ url('/operator/dashboard') }}">Dashboard</a>
            <a href="{{ url('/operator/stasiun') }}">Stasiun</a>
            <a href="{{ route('operator.charger.index') }}" class="active">Charger</a>
            <a href="{{ url('/operator/tarif') }}">Tarif</a>
        </nav>
    </div>

    <div class="container">
        <div class="page-head">
            <h1>Tambah Charger</h1>
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

        <div class="card">
            @if ($stations->isEmpty())
                <div class="empty">Anda belum memiliki stasiun aktif. Aktifkan stasiun terlebih dahulu.</div>
            @else
                <form action="{{ route('operator.charger.store') }}" method="POST">
                    @csrf
                    @include('operator.charger.form', [
                        'action'      => route('operator.charger.store'),
                        'submitLabel' => 'Simpan',
                    ])
                    <div class="form-actions">
                        <button type="submit" class="btn">Simpan</button>
                        <a href="{{ route('operator.charger.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>