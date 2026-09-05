<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kost - KosMatch</title>

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
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #4353ff;
            color: white;
        }

        .filter {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;

            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 12px;
        }

        .filter input,
        .filter select {
            width: 100%;
            padding: 11px;

            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .kost-grid {
            display: grid;
            grid-template-columns:
                repeat(auto-fill, minmax(280px, 1fr));

            gap: 20px;
        }

        .kost-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, .06);
        }

        .kost-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .kost-content {
            padding: 20px;
        }

        .kost-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .city {
            color: #6b7280;
            margin-bottom: 12px;
        }

        .price {
            color: #4353ff;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .facility-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 18px;
        }

        .facility {
            background: #eef2ff;
            color: #3730a3;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
        }

        .empty {
            background: white;
            padding: 50px;
            text-align: center;
            border-radius: 12px;
        }

        @media (max-width: 800px) {
            .filter {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>Cari Kost</h1>

            <p>
                Temukan kost yang sesuai dengan kebutuhanmu.
            </p>
        </div>

        <div>
            <a
                href="{{ route('student.dashboard') }}"
                class="btn btn-primary"
            >
                Dashboard
            </a>

            <a
                href="{{ route('student.bookings.index') }}"
                class="btn btn-primary"
            >
                Booking Saya
            </a>
        </div>

    </div>


    {{-- FILTER --}}
    <form
        action="{{ route('student.kosts.index') }}"
        method="GET"
        class="filter"
    >

        <input
            type="text"
            name="search"
            placeholder="Cari nama kost..."
            value="{{ request('search') }}"
        >


        <select name="city">

            <option value="">
                Semua Kota
            </option>

            @foreach ($cities as $city)

                <option
                    value="{{ $city }}"
                    {{ request('city') === $city ? 'selected' : '' }}
                >
                    {{ $city }}
                </option>

            @endforeach

        </select>


        <select name="gender_type">

            <option value="">
                Semua Gender
            </option>

            <option
                value="male"
                {{ request('gender_type') === 'male' ? 'selected' : '' }}
            >
                Putra
            </option>

            <option
                value="female"
                {{ request('gender_type') === 'female' ? 'selected' : '' }}
            >
                Putri
            </option>

            <option
                value="mixed"
                {{ request('gender_type') === 'mixed' ? 'selected' : '' }}
            >
                Campur
            </option>

        </select>


        <input
            type="number"
            name="max_price"
            placeholder="Harga maksimal"
            value="{{ request('max_price') }}"
        >


        <button
            type="submit"
            class="btn btn-primary"
        >
            Cari
        </button>

    </form>


    {{-- DAFTAR KOST --}}
    @if ($kosts->count())

        <div class="kost-grid">

            @foreach ($kosts as $kost)

                <div class="kost-card">

                    <img
                        src="{{ asset('storage/' . $kost->image) }}"
                        alt="{{ $kost->name }}"
                        class="kost-image"
                    >


                    <div class="kost-content">

                        <div class="kost-name">
                            {{ $kost->name }}
                        </div>


                        <div class="city">
                            📍 {{ $kost->city }}
                        </div>


                        <div class="price">
                            Rp
                            {{ number_format($kost->price, 0, ',', '.') }}
                            / bulan
                        </div>


                        {{-- FASILITAS --}}
                        <div class="facility-list">

                            @foreach ($kost->facilities as $facility)

                                @if ($facility->pivot->is_available)

                                    <span class="facility">
                                        {{ $facility->name }}
                                    </span>

                                @endif

                            @endforeach

                        </div>


                        <a
                            href="{{ route('student.kosts.show', $kost) }}"
                            class="btn btn-primary"
                        >
                            Lihat Detail
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <h2>
                Kost tidak ditemukan
            </h2>

            <p style="margin-top:10px;color:#6b7280;">
                Coba ubah kata pencarian atau filter.
            </p>

        </div>

    @endif

</div>

</body>

</html>