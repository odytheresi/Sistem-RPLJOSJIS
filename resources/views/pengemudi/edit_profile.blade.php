<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profil Pengemudi</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 6px;
            color: #111827;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 25px;
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
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        }

        .password-info {
            background: #f0fdfa;
            color: #115e59;
            padding: 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 18px;
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

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .button {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 10px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .save-button {
            background: #0f766e;
            color: white;
        }

        .save-button:hover {
            background: #115e59;
        }

        .cancel-button {
            background: #e5e7eb;
            color: #374151;
        }

        .cancel-button:hover {
            background: #d1d5db;
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .container {
                margin: 10px auto;
                padding: 20px;
                border-radius: 16px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Profil</h2>

    <div class="subtitle">
        Perbarui informasi akun pengemudi kamu.
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

    <form action="{{ route('pengemudi.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nma_user">
                Nama Pengemudi
            </label>

            <input
                type="text"
                id="nma_user"
                name="nma_user"
                value="{{ old('nma_user', $pengemudi->nma_user) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $pengemudi->email) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="no_hp">
                Nomor HP
            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                value="{{ old('no_hp', $pengemudi->no_hp) }}"
                required
            >
        </div>

        <div class="password-info">
            Kosongkan password jika kamu tidak ingin mengganti password.
        </div>

        <div class="form-group">
            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password baru"
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Ulangi password baru"
            >
        </div>

        <div class="button-group">
            <a href="{{ route('pengemudi.profile') }}"
               class="button cancel-button">
                Batal
            </a>
            <button type="submit"
                    class="button save-button">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
</body>
</html>