<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Tambah Kamar - {{ $kost->name }}
    </title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #2563eb;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .help {
            margin-top: 6px;
            color: #6b7280;
            font-size: 13px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert ul {
            margin-left: 20px;
            margin-top: 8px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>
            Tambah Kamar
        </h1>

        <p class="subtitle">
            Tambahkan kamar untuk
            <strong>{{ $kost->name }}</strong>
        </p>


      
        @if ($errors->any())

            <div class="alert">

                <strong>
                    Terjadi kesalahan:
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('owner.kosts.rooms.store', $kost) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


           
            <div class="form-group">

                <label for="room_number">
                    Nomor Kamar
                </label>

                <input
                    type="text"
                    id="room_number"
                    name="room_number"
                    value="{{ old('room_number') }}"
                    placeholder="Contoh: A01"
                    required
                >

                @error('room_number')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            
            <div class="form-group">

                <label for="price">
                    Harga Kamar / Bulan
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    placeholder="Contoh: 1500000"
                    min="0"
                    required
                >

                <div class="help">
                    Masukkan harga kamar dalam Rupiah.
                </div>

                @error('price')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


          
            <div class="form-group">

                <label for="status">
                    Status Kamar
                </label>

                <select
                    id="status"
                    name="status"
                    required
                >

                    <option
                        value="available"
                        {{ old('status', 'available') === 'available' ? 'selected' : '' }}
                    >
                        Available / Tersedia
                    </option>

                    <option
                        value="booked"
                        {{ old('status') === 'booked' ? 'selected' : '' }}
                    >
                        Booked / Terisi
                    </option>

                    <option
                        value="inactive"
                        {{ old('status') === 'inactive' ? 'selected' : '' }}
                    >
                        Inactive / Tidak Aktif
                    </option>

                </select>

                @error('status')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


          
            <div class="form-group">

                <label for="images">
                    Foto Kamar
                </label>

                <input
                    type="file"
                    id="images"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/png,image/webp"
                >

                <div class="help">
                    Bisa memilih beberapa foto sekaligus.
                    Format: JPG, JPEG, PNG, WEBP.
                    Maksimal 2 MB per foto.
                </div>

                @error('images')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

                @error('images.*')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            
            <div class="buttons">

                <a
                    href="{{ route('owner.kosts.rooms.index', $kost) }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Kamar
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>