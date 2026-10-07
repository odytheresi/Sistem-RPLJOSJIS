<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Pengemudi</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f3f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 30px 25px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
        .logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 18px;
            background: #ccfbf1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        h2 {
            text-align: center;
            margin: 0;
            color: #111827;
            font-size: 24px;
        }
        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin: 8px 0 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
            color: #374151;
        }
        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }
        input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        }
        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #0f766e;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 5px;
        }
        button:hover {
            background: #115e59;
        }
        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
        }
        .error ul {
            margin: 0;
            padding-left: 18px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        .register-link a {
            color: #0f766e;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            .login-container {
                padding: 25px 20px;
                border-radius: 18px;
            }
            h2 {
                font-size: 22px;
            }  }
    </style>
</head>

<body>
<div class="login-container">
    <div class="logo">
        ⚡
    </div>

    <h2>Login Pengemudi</h2>
    <div class="subtitle">
        Sistem Manajemen Charging EV
    </div>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengemudi.login.process') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nma_user">
                Nama Pengemudi
            </label>

            <input
                type="text"
                id="nma_user"
                name="nma_user"
                value="{{ old('nma_user') }}"
                placeholder="Masukkan nama pengemudi"
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label for="password">
                Password
            </label>
            
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
            >
        </div>
        <button type="submit">
            Login
        </button>
    </form>

    <div class="register-link">
        Belum punya akun?
        <a href="{{ route('pengemudi.register') }}">
            Daftar di sini
        </a>
    </div>
</div>
</body>
</html>