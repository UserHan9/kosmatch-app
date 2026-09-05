{{-- @php($active = 'properties') --}}
@extends('layouts.app')

@section('title', 'Kost Saya - KosMatch')
@section('page-title', 'Kost Saya')

@section('styles')
    .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .header p {
        color: #6b7280;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
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
        background: #e5e7eb;
        color: #111827;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
        background: #dcfce7;
        color: #166534;
    }

    .kosts {
        display: grid;
        grid-template-columns: repeat(
            auto-fill,
            minmax(300px, 1fr)
        );

        gap: 20px;
    }

    .kost-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .kost-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .no-image {
        height: 200px;
        background: #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #6b7280;
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
        font-size: 18px;
        font-weight: bold;
        color: #2563eb;
        margin-bottom: 12px;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 18px;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .actions form {
        display: inline;
    }

    .empty {
        background: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 12px;
    }

    .empty h2 {
        margin-bottom: 10px;
    }

    .empty p {
        color: #6b7280;
        margin-bottom: 20px;
    }

    @media (max-width: 600px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .kosts {
            grid-template-columns: 1fr;
        }
    }
@endsection

@section('content')

    <div class="container">


        <div class="header">

            <div>
                <h1>Kost Saya</h1>

                <p>
                    Kelola kost yang kamu miliki.
                </p>
            </div>

            <a
                href="{{ route('owner.kosts.create') }}"
                class="btn btn-primary"
            >
                + Tambah Kost
            </a>

        </div>



        @if (session('success'))

            <div class="alert">
                {{ session('success') }}
            </div>

        @endif



        @if ($kosts->count() > 0)

            <div class="kosts">

                @foreach ($kosts as $kost)

                    <div class="kost-card">


                        @if ($kost->image)

                            <img
                                src="{{ asset('storage/' . $kost->image) }}"
                                alt="{{ $kost->name }}"
                                class="kost-image"
                            >

                        @else

                            <div class="no-image">
                                Belum ada gambar
                            </div>

                        @endif



                        <div class="kost-content">

                            <div class="kost-name">
                                {{ $kost->name }}
                            </div>

                            <div class="city">
                                📍 {{ $kost->city }}
                            </div>

                            <div class="price">
                                Rp {{ number_format($kost->price, 0, ',', '.') }}
                            </div>



                            @if ($kost->status === 'active')

                                <span class="status status-active">
                                    Aktif
                                </span>

                            @else

                                <span class="status status-inactive">
                                    Tidak Aktif
                                </span>

                            @endif


                            <div class="actions">


                                <a
                                    href="{{ route('owner.kosts.show', $kost) }}"
                                    class="btn btn-secondary"
                                >
                                    Detail
                                </a>



                                <a
                                    href="{{ route('owner.kosts.rooms.index', $kost) }}"
                                    class="btn btn-primary"
                                >
                                    Kamar
                                </a>


                                <a
                                    href="{{ route('owner.kosts.edit', $kost) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
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

                @endforeach

            </div>

        @else

            {{-- EMPTY --}}
            <div class="empty">

                <h2>
                    Belum ada kost
                </h2>

                <p>
                    Kamu belum memiliki kost.
                </p>

                <a
                    href="{{ route('owner.kosts.create') }}"
                    class="btn btn-primary"
                >
                    + Tambah Kost
                </a>

            </div>

        @endif

    </div>

@endsection