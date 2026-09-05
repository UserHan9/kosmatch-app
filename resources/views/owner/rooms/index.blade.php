<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kamar {{ $kost->name }} - KosMatch</title>

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
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.07);
        }

        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .images {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            margin-top: 15px;
        }

        .images img {
            width: 180px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .btn {
            padding: 9px 14px;
            border-radius: 7px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .empty {
            text-align: center;
            padding: 50px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>KosMatch</strong>
</div>

<div class="container">

    <div class="header">

        <div>
            <h1>Kamar {{ $kost->name }}</h1>
            <p>Kelola kamar pada kost ini.</p>
        </div>

        <a
            href="{{ route('owner.kosts.rooms.create', $kost) }}"
            class="btn btn-primary"
        >
            + Tambah Kamar
        </a>

    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($kost->rooms as $room)

        <div class="card">

            <div class="room-header">

                <div>
                    <h2>
                        Kamar {{ $room->room_number }}
                    </h2>

                    <p>
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                        / bulan
                    </p>

                    <p>
                        Status:
                        <strong>
                            {{ ucfirst($room->status) }}
                        </strong>
                    </p>
                </div>

            </div>

            @if ($room->images->count() > 0)

                <div class="images">

                    @foreach ($room->images as $image)

                        <img
                            src="{{ asset('storage/' . $image->image) }}"
                            alt="Foto kamar {{ $room->room_number }}"
                        >

                    @endforeach

                </div>

            @else

                <p>
                    Belum ada foto kamar.
                </p>

            @endif

            <div class="actions">

                <a
                    href="{{ route('owner.kosts.rooms.edit', [$kost, $room]) }}"
                    class="btn btn-warning"
                >
                    Edit
                </a>

                <form
                    action="{{ route('owner.kosts.rooms.destroy', [$kost, $room]) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kamar ini?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Hapus
                    </button>

                </form>

            </div>

        </div>

    @empty

        <div class="card empty">

            <h2>Belum ada kamar</h2>

            <p>
                Tambahkan kamar pertama untuk kost ini.
            </p>

            <a
                href="{{ route('owner.kosts.rooms.create', $kost) }}"
                class="btn btn-primary"
            >
                + Tambah Kamar
            </a>

        </div>

    @endforelse

    <a
        href="{{ route('owner.kosts.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali ke Kost
    </a>

</div>

</body>
</html>