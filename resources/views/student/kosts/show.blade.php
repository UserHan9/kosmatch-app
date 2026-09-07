<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $kost->name }} - KosMatch
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
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #4353ff;
            text-decoration: none;
        }

        .main-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .06);
        }

        .cover {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .content {
            padding: 30px;
        }

        .title {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .location {
            color: #6b7280;
            margin-bottom: 15px;
        }

        .price {
            color: #4353ff;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .section {
            margin-top: 30px;
        }

        .section h2 {
            margin-bottom: 15px;
        }

        .description {
            line-height: 1.7;
            color: #4b5563;
        }

        .facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .facility {
            padding: 8px 14px;
            background: #eef2ff;
            color: #3730a3;
            border-radius: 20px;
            font-size: 14px;
        }

        .rooms {
            display: grid;
            grid-template-columns:
                repeat(auto-fill, minmax(280px, 1fr));

            gap: 18px;
        }

        .room {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .room-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .room-no-image {
            height: 180px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .room-content {
            padding: 18px;
        }

        .room-title {
            font-size: 19px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .room-price {
            color: #4353ff;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .available {
            background: #dcfce7;
            color: #166534;
        }

        .booked {
            background: #fee2e2;
            color: #991b1b;
        }

        .inactive {
            background: #e5e7eb;
            color: #374151;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 11px 15px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .btn-primary {
            background: #4353ff;
            color: white;
        }

        .btn-disabled {
            background: #e5e7eb;
            color: #6b7280;
            cursor: not-allowed;
        }

        .address {
            line-height: 1.7;
            color: #4b5563;
        }

        .empty {
            background: #f9fafb;
            padding: 25px;
            border-radius: 10px;
            color: #6b7280;
        }

        @media (max-width: 700px) {
            .cover {
                height: 250px;
            }

            .content {
                padding: 20px;
            }

            .title {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a
    href="{{ route('chat.start', $kost) }}"
    style="
        display:inline-block;
        padding:12px 20px;
        background:#111827;
        color:white;
        border-radius:8px;
        text-decoration:none;
    "
>
    💬 Chat Owner
</a>

    <a
        href="{{ route('student.kosts.index') }}"
        class="back"
    >
        ← Kembali ke daftar kost
    </a>


    <div class="main-card">

        {{-- COVER --}}
        <img
            src="{{ asset('storage/' . $kost->image) }}"
            alt="{{ $kost->name }}"
            class="cover"
        >


        <div class="content">

            {{-- INFORMASI KOST --}}

            <h1 class="title">
                {{ $kost->name }}
            </h1>

            <p class="location">
                📍 {{ $kost->city }}
            </p>

            <div class="price">
                Rp {{ number_format($kost->price, 0, ',', '.') }}
                / bulan
            </div>


            {{-- ALAMAT --}}

            <div class="section">

                <h2>
                    Alamat
                </h2>

                <p class="address">
                    {{ $kost->address }}
                </p>

            </div>


            {{-- DESKRIPSI --}}

            <div class="section">

                <h2>
                    Tentang Kost
                </h2>

                <p class="description">
                    {{ $kost->description ?: 'Tidak ada deskripsi.' }}
                </p>

            </div>


            {{-- FASILITAS --}}

            <div class="section">

                <h2>
                    Fasilitas
                </h2>

                <div class="facilities">

                    @forelse ($kost->facilities as $facility)

                        @if ($facility->pivot->is_available)

                            <span class="facility">
                                ✓ {{ $facility->name }}
                            </span>

                        @endif

                    @empty

                        <span>
                            Belum ada fasilitas.
                        </span>

                    @endforelse

                </div>

            </div>


            {{-- KAMAR --}}

            <div class="section">

                <h2>
                    Kamar Tersedia
                </h2>


                @if ($kost->rooms->count())

                    <div class="rooms">

                        @foreach ($kost->rooms as $room)

                            <div class="room">

                                {{-- GAMBAR KAMAR --}}

                                @if ($room->images->count())

                                    <img
                                        src="{{ asset('storage/' . $room->images->first()->image) }}"
                                        alt="Kamar {{ $room->room_number }}"
                                        class="room-image"
                                    >

                                @else

                                    <div class="room-no-image">
                                        Tidak ada foto kamar
                                    </div>

                                @endif


                                <div class="room-content">

                                    <div class="room-title">
                                        Kamar {{ $room->room_number }}
                                    </div>


                                    <div class="room-price">
                                        Rp
                                        {{ number_format($room->price, 0, ',', '.') }}
                                        / bulan
                                    </div>


                                    {{-- STATUS --}}

                                    @if ($room->status === 'available')

                                        <span class="status available">
                                            Available
                                        </span>

                                    @elseif ($room->status === 'booked')

                                        <span class="status booked">
                                            Booked
                                        </span>

                                    @else

                                        <span class="status inactive">
                                            Inactive
                                        </span>

                                    @endif


                                    {{-- BOOKING --}}

                                    @if ($room->status === 'available')

                                        <a
                                            href="{{ route(
                                                'student.bookings.create',
                                                $room
                                            ) }}"
                                            class="btn btn-primary"
                                        >
                                            Booking Sekarang
                                        </a>

                                    @else

                                        <span
                                            class="btn btn-disabled"
                                        >
                                            Tidak Tersedia
                                        </span>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="empty">

                        Belum ada kamar yang tersedia
                        untuk kost ini.

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

</body>

</html>