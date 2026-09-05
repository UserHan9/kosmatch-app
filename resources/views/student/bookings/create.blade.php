<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Booking Kamar - KosMatch
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
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .06);
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .room-info {
            background: #f4f6fb;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .room-info h2 {
            margin-bottom: 8px;
        }

        .price {
            color: #4353ff;
            font-weight: bold;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;

            border: 1px solid #d1d5db;
            border-radius: 8px;

            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #4353ff;
        }

        .error {
            color: #dc2626;
            margin-top: 6px;
            font-size: 13px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #4353ff;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>
            Booking Kamar
        </h1>

        <p class="subtitle">
            Silakan tentukan periode tinggal kamu.
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


        {{-- INFO KAMAR --}}
        <div class="room-info">

            <h2>
                Kamar {{ $room->room_number }}
            </h2>

            <p>
                {{ $room->kost->name }}
            </p>

            <div class="price">
                Rp {{ number_format($room->price, 0, ',', '.') }}
                / bulan
            </div>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('student.bookings.store', $room) }}"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label for="start_date">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ old('start_date') }}"
                    min="{{ date('Y-m-d') }}"
                    required
                >

                @error('start_date')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="form-group">

                <label for="end_date">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ old('end_date') }}"
                    required
                >

                @error('end_date')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <div class="buttons">

                <a
                    href="{{ url()->previous() }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Lanjutkan Booking
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>