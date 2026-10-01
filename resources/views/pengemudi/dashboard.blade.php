<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengemudi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
        }

        .info {
            background: #eff6ff;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background: #dc2626;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Dashboard Pengemudi</h1>

    <div class="info">
        <p>Selamat datang di Sistem Manajemen Charging EV.</p>
        <p>Login sebagai pengemudi berhasil.</p>
    </div>

    <form action="{{ route('pengemudi.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</div>

</body>
</html>