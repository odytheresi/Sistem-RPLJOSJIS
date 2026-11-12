<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengemudi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .profile-item {
            margin-bottom: 18px;
        }

        .profile-item label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .profile-item p {
            margin: 0;
            padding: 10px;
            background: #f3f4f6;
            border-radius: 6px;
        }

        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .edit-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #0f766e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 8px;
        }

        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
    
        .alert-success {
            display: block;
            width: 100%;
            box-sizing: border-box;
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
            border-left: 5px solid #059669;
            padding: 14px 18px;
            margin: 20px 0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-danger {
            display: block;
            width: 100%;
            box-sizing: border-box;
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
            border-left: 5px solid #dc2626;
            padding: 14px 18px;
            margin: 20px 0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>Profil Pengemudi</h2>

    {{-- Notifikasi berhasil --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi gagal --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="profile-item">
        <label>Nama Lengkap</label>
        <p>{{ $pengemudi->nma_user }}</p>
    </div>

    <div class="profile-item">
        <label>Email</label>
        <p>{{ $pengemudi->email }}</p>
    </div>

    <div class="profile-item">
        <label>Nomor HP</label>
        <p>{{ $pengemudi->no_hp }}</p>
    </div>

    <div class="profile-item">
        <label>Status Akun</label>
        <p>{{ $pengemudi->status }}</p>
    </div>

    <a href="{{ route('pengemudi.profile.edit') }}"
       class="edit-button">
        Edit Profil
    </a>

    <a href="{{ route('pengemudi.dashboard') }}"
       class="back-button">
        Kembali ke Dashboard
    </a>

</div>

</body>
</html>