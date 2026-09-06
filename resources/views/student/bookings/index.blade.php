@extends('layouts.app2')

@section('title', 'Booking Saya - KosMatch')
@section('page-title', 'Booking Saya')

@section('content')

<div style="max-width:1000px;margin:40px auto;font-family:Arial;">

    <h1>Booking Saya</h1>

    <br>

    @if (session('success'))

        <div
            style="
                background:#dcfce7;
                color:#166534;
                padding:15px;
                margin-bottom:20px;
                border-radius:8px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    @forelse ($bookings as $booking)

        <div
            style="
                background:white;
                border:1px solid #e5e7eb;
                border-radius:10px;
                padding:20px;
                margin-bottom:15px;
            "
        >

            <h2>
                {{ $booking->room->kost->name }}
            </h2>

            <p>
                Kamar:
                {{ $booking->room->room_number }}
            </p>

            <p>
                Mulai:
                {{ $booking->start_date->format('d M Y') }}
            </p>

            <p>
                Selesai:
                {{ $booking->end_date->format('d M Y') }}
            </p>

            <p>
                Total:
                <strong>
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </strong>
            </p>

            <p>
                Booking:
                <strong>
                    {{ ucfirst($booking->status) }}
                </strong>
            </p>

            <p>
                Pembayaran:
                <strong>
                    {{ ucfirst($booking->payment_status) }}
                </strong>
            </p>

            <br>

            <a
                href="{{ route('student.bookings.show', $booking) }}"
            >
                Lihat Detail
            </a>

        </div>

    @empty

        <p>
            Belum ada booking.
        </p>

    @endforelse

</div>

@endsection