<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Saya</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        h2 {
            margin-top: 0;
            color: #1f2937;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .add-button, .edit-button, .back-button, .delete-button {
            display: inline-block;
            padding: 10px 14px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .add-button {
            background: #2563eb;
            color: white;
            margin-bottom: 20px;
        }

        .edit-button {
            background: #f59e0b;
            color: white;
        }

        .back-button {
            background: #6b7280;
            color: white;
            margin-top: 20px;
        }

        .delete-button {
            background: #dc2626;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        @media (max-width: 650px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 15px;
                overflow-x: auto;
            }

            table {
                min-width: 650px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Kendaraan Saya</h2>

    @if (session('success'))
        <div class="success">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="success" style="background:#fee2e2;color:#991b1b;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('pengemudi.kendaraan.create') }}"
       class="add-button">
        + Tambah Kendaraan
    </a>

    @if ($kendaraans->isEmpty())
        <div class="empty">
            Belum ada kendaraan yang terdaftar.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nomor Plat</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Kapasitas Baterai (kWh)</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kendaraans as $kendaraan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kendaraan->no_plat }}</td>
                        <td>{{ $kendaraan->merk }}</td>
                        <td>{{ $kendaraan->model }}</td>
                        <td>{{ $kendaraan->kapasitas_baterai }}</td>
                        <td>
                            <a href="{{ route('pengemudi.kendaraan.edit', $kendaraan->id_kendaraan) }}"
                               class="edit-button">
                                Edit
                            </a>

                            <form action="{{ route('pengemudi.kendaraan.destroy', $kendaraan->id_kendaraan) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="delete-button">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('pengemudi.dashboard') }}" class="back-button">
        Kembali ke Dashboard
    </a>

</div>
</body>
</html>