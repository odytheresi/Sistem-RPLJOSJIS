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
    </style>
</head>

<body>

<div class="container">

    <h2>Profil Pengemudi</h2>

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

    <a href="{{ route('pengemudi.dashboard') }}" class="back-button">
        Kembali ke Dashboard
    </a>

</div>

</body>
</html>