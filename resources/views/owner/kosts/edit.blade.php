<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit {{ $kost->name }} - KosMatch</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .navbar {
            background: #111827;
            color: white;
            padding: 18px 40px;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input[type="file"] {
            padding: 8px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .radio-group,
        .facility-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-item,
        .facility-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
        }

        .radio-item input,
        .facility-item input {
            width: auto;
        }

        .current-image {
            width: 300px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>KosMatch</strong>
</div>

<div class="container">

    <div class="card">

        <h1>Edit Kost</h1>

        <p>
            Perbarui informasi {{ $kost->name }}.
        </p>

        @if ($errors->any())

            <div class="error">

                <strong>Terjadi kesalahan:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <form
            action="{{ route('owner.kosts.update', $kost) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="name">
                    Nama Kost *
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $kost->name) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="description">
                    Deskripsi
                </label>

                <textarea
                    id="description"
                    name="description"
                >{{ old('description', $kost->description) }}</textarea>

            </div>

            <div class="form-group">

                <label>
                    Foto Cover Saat Ini
                </label>

                <br>

                <img
                    src="{{ asset('storage/' . $kost->image) }}"
                    alt="{{ $kost->name }}"
                    class="current-image"
                >

                <label for="image">
                    Ganti Foto Cover
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Kosongkan jika tidak ingin mengganti foto.
                </small>

            </div>

            <div class="form-group">

                <label for="city">
                    Kota *
                </label>

                <select name="city" id="city" required>

                    @foreach ([
                        'Jakarta',
                        'Bandung',
                        'Bogor',
                        'Depok',
                        'Bekasi',
                        'Tangerang'
                    ] as $city)

                        <option
                            value="{{ $city }}"
                            {{ old('city', $kost->city) === $city ? 'selected' : '' }}
                        >
                            {{ $city }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label for="address">
                    Alamat *
                </label>

                <textarea
                    id="address"
                    name="address"
                    required
                >{{ old('address', $kost->address) }}</textarea>

            </div>

            <div class="row">

                <div class="form-group">

                    <label for="latitude">
                        Latitude
                    </label>

                    <input
                        type="number"
                        step="any"
                        id="latitude"
                        name="latitude"
                        value="{{ old('latitude', $kost->latitude) }}"
                    >

                </div>

                <div class="form-group">

                    <label for="longitude">
                        Longitude
                    </label>

                    <input
                        type="number"
                        step="any"
                        id="longitude"
                        name="longitude"
                        value="{{ old('longitude', $kost->longitude) }}"
                    >

                </div>

            </div>

            <div class="form-group">

                <label for="price">
                    Harga per Bulan *
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    min="0"
                    value="{{ old('price', $kost->price) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Jenis Kost *
                </label>

                <div class="radio-group">

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="male"
                            {{ old('gender_type', $kost->gender_type) === 'male' ? 'checked' : '' }}
                        >
                        Putra
                    </label>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="female"
                            {{ old('gender_type', $kost->gender_type) === 'female' ? 'checked' : '' }}
                        >
                        Putri
                    </label>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="mixed"
                            {{ old('gender_type', $kost->gender_type) === 'mixed' ? 'checked' : '' }}
                        >
                        Campur
                    </label>

                </div>

            </div>

            <div class="form-group">

                <label>
                    Status *
                </label>

                <div class="radio-group">

                    <label class="radio-item">

                        <input
                            type="radio"
                            name="status"
                            value="active"
                            {{ old('status', $kost->status) === 'active' ? 'checked' : '' }}
                        >

                        Aktif

                    </label>

                    <label class="radio-item">

                        <input
                            type="radio"
                            name="status"
                            value="inactive"
                            {{ old('status', $kost->status) === 'inactive' ? 'checked' : '' }}
                        >

                        Tidak Aktif

                    </label>

                </div>

            </div>

            <div class="form-group">

                <label>
                    Fasilitas
                </label>

                <div class="facility-group">

                    @foreach ($facilities as $facility)

                        @php
                            $selectedFacilities = old(
                                'facilities',
                                $kost->facilities->pluck('id')->toArray()
                            );
                        @endphp

                        <label class="facility-item">

                            <input
                                type="checkbox"
                                name="facilities[]"
                                value="{{ $facility->id }}"
                                {{ in_array($facility->id, $selectedFacilities) ? 'checked' : '' }}
                            >

                            {{ $facility->name }}

                        </label>

                    @endforeach

                </div>

            </div>

            <div class="actions">

                <a
                    href="{{ route('owner.kosts.index') }}"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Update Kost
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>