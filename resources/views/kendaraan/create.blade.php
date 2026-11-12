<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        .button {
            display: inline-block;
            padding: 11px 15px;
            margin-top: 20px;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .save {
            background: #2563eb;
        }

        .back {
            background: #6b7280;
        }

        .error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Tambah Kendaraan</h2>

    <form action="{{ route('pengemudi.kendaraan.store') }}" method="POST">
        @csrf

        <label>Nomor Plat</label>
        <input type="text" name="no_plat"
               value="{{ old('no_plat') }}"
               placeholder="Contoh: AB 1234 CD"
               maxlength="15" required>
        @error('no_plat')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Merk Kendaraan</label>
        <input type="text" name="merk"
               value="{{ old('merk') }}"
               placeholder="Contoh: Hyundai"
               maxlength="50" required>
        @error('merk')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Model Kendaraan</label>
        <input type="text" name="model"
               value="{{ old('model') }}"
               placeholder="Contoh: IONIQ 5"
               maxlength="50" required>
        @error('model')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Kapasitas Baterai (kWh)</label>
        <input type="number" name="kapasitas_baterai"
               value="{{ old('kapasitas_baterai') }}"
               min="0.01" max="999999.99" step="0.01"
               placeholder="Contoh: 58" required>
        @error('kapasitas_baterai')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="button save">
            Simpan Kendaraan
        </button>

        <a href="{{ route('pengemudi.kendaraan.index') }}"
           class="button back">
            Batal
        </a>
    </form>

</div>
</body>
</html>
