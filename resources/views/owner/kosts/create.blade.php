<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kost - KosMatch</title>

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
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
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

        .required {
            color: #dc2626;
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
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        @media (max-width: 600px) {
            .row {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>KosMatch</strong>
</div>

<div class="container">

    <div class="card">

        <h1>Tambah Kost</h1>

        <p>
            Tambahkan informasi kost yang ingin Anda kelola.
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
            action="{{ route('owner.kosts.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

          
            <div class="form-group">
                <label for="name">
                    Nama Kost <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Kost Harmoni"
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
                    placeholder="Deskripsikan kost Anda..."
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">
                    Foto Cover <span class="required">*</span>
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >

                <small>
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </small>
            </div>

            
            <div class="form-group">
                <label for="city">
                    Kota <span class="required">*</span>
                </label>

                <select name="city" id="city" required>

                    <option value="">
                        -- Pilih Kota --
                    </option>

                    <option value="Jakarta"
                        {{ old('city') === 'Jakarta' ? 'selected' : '' }}>
                        Jakarta
                    </option>

                    <option value="Bandung"
                        {{ old('city') === 'Bandung' ? 'selected' : '' }}>
                        Bandung
                    </option>

                    <option value="Bogor"
                        {{ old('city') === 'Bogor' ? 'selected' : '' }}>
                        Bogor
                    </option>

                    <option value="Depok"
                        {{ old('city') === 'Depok' ? 'selected' : '' }}>
                        Depok
                    </option>

                    <option value="Bekasi"
                        {{ old('city') === 'Bekasi' ? 'selected' : '' }}>
                        Bekasi
                    </option>

                    <option value="Tangerang"
                        {{ old('city') === 'Tangerang' ? 'selected' : '' }}>
                        Tangerang
                    </option>

                </select>
            </div>

            
            <div class="form-group">
                <label for="address">
                    Alamat <span class="required">*</span>
                </label>

                <textarea
                    id="address"
                    name="address"
                    placeholder="Masukkan alamat lengkap..."
                    required
                >{{ old('address') }}</textarea>
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
                        value="{{ old('latitude') }}"
                        placeholder="-6.914744"
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
                        value="{{ old('longitude') }}"
                        placeholder="107.609810"
                    >
                </div>

            </div>

          
            <div class="form-group">
                <label for="price">
                    Harga per Bulan <span class="required">*</span>
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    placeholder="1200000"
                    required
                >
            </div>

          
            <div class="form-group">

                <label>
                    Jenis Kost <span class="required">*</span>
                </label>

                <div class="radio-group">

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="male"
                            {{ old('gender_type') === 'male' ? 'checked' : '' }}
                        >
                        Putra
                    </label>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="female"
                            {{ old('gender_type') === 'female' ? 'checked' : '' }}
                        >
                        Putri
                    </label>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="gender_type"
                            value="mixed"
                            {{ old('gender_type') === 'mixed' ? 'checked' : '' }}
                        >
                        Campur
                    </label>

                </div>

            </div>

           
            <div class="form-group">

                <label>
                    Status <span class="required">*</span>
                </label>

                <div class="radio-group">

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="status"
                            value="active"
                            {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                        >
                        Aktif
                    </label>

                    <label class="radio-item">
                        <input
                            type="radio"
                            name="status"
                            value="inactive"
                            {{ old('status') === 'inactive' ? 'checked' : '' }}
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

                        <label class="facility-item">

                            <input
                                type="checkbox"
                                name="facilities[]"
                                value="{{ $facility->id }}"
                                {{ in_array(
                                    $facility->id,
                                    old('facilities', [])
                                ) ? 'checked' : '' }}
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
                    Selanjutnya
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>