<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $kost->name }} - KosMatch</title>

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
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .cover {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .content {
            padding: 30px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
        }

        .info {
            margin: 10px 0;
        }

        .section {
            margin-top: 30px;
        }

        .facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .facility {
            padding: 8px 14px;
            background: #e5e7eb;
            border-radius: 20px;
        }

        .rooms {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .room {
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 10px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .status-active {
            color: #15803d;
            font-weight: bold;
        }

        .status-inactive {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>KosMatch</strong>
</div>

<div class="container">

    <div class="card">

        <img
            src="{{ asset('storage/' . $kost->image) }}"
            alt="{{ $kost->name }}"
            class="cover"
        >

        <div class="content">

            <h1>{{ $kost->name }}</h1>

            <div class="info">
                📍 {{ $kost->city }}
            </div>

            <div class="price">
                Rp {{ number_format($kost->price, 0, ',', '.') }}
                / bulan
            </div>

            <div class="info">
                Jenis:
                @if ($kost->gender_type === 'male')
                    Putra
                @elseif ($kost->gender_type === 'female')
                    Putri
                @else
                    Campur
                @endif
            </div>

            <div class="info">
                Status:

                @if ($kost->status === 'active')
                    <span class="status-active">🟢 Aktif</span>
                @else
                    <span class="status-inactive">🔴 Tidak Aktif</span>
                @endif
            </div>

            <div class="section">

                <h2>Deskripsi</h2>

                <p>
                    {{ $kost->description ?? 'Tidak ada deskripsi.' }}
                </p>

            </div>

            <div class="section">

                <h2>Alamat</h2>

                <p>
                    {{ $kost->address }}
                </p>

            </div>

            <div class="section">

                <h2>Fasilitas</h2>

                <div class="facilities">

                    @forelse ($kost->facilities as $facility)

                        <div class="facility">
                            ✓ {{ $facility->name }}
                        </div>

                    @empty

                        <p>Belum ada fasilitas.</p>

                    @endforelse

                </div>

            </div>

            <div class="section">

                <h2>Kamar</h2>

                <div class="rooms">

                    @forelse ($kost->rooms as $room)

                        <div class="room">

                            <strong>
                                Kamar {{ $room->room_number }}
                            </strong>

                            <p>
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </p>

                            <p>
                                Status:
                                {{ ucfirst($room->status) }}
                            </p>

                        </div>

                    @empty

                        <p>
                            Belum ada kamar.
                        </p>

                    @endforelse

                </div>

            </div>

            <div class="actions">

                <a
                    href="{{ route('owner.kosts.index') }}"
                    class="btn btn-secondary"
                >
                    ← Kembali
                </a>

                <a
                    href="{{ route('owner.kosts.edit', $kost) }}"
                    class="btn btn-primary"
                >
                    Edit Kost
                </a>

                <form
                    action="{{ route('owner.kosts.destroy', $kost) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus kost ini?')"
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

    </div>

</div>

</body>
</html>