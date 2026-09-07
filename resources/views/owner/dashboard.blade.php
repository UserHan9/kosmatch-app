@php($active = 'dashboard')

@extends('layouts.app')

@section('title', 'Owner Dashboard - KosMatch')

@section('page-title', 'Dashboard')

@section('styles')
 .content-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .content-card h1 {
        font-size: 22px;
        margin-bottom: 12px;
    }

    .content-card p {
        margin-bottom: 8px;
        color: #4b5563;
    }

    .logout-form {
        margin-top: 16px;
    }

    .logout-form button {
        background: #ef4444;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .logout-form button:hover {
        background: #dc2626;
    }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 30px;
    margin-bottom: 24px;
}

.stat-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}

.stat-label {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 10px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}

.content-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}

.content-card h1 {
    font-size: 22px;
    margin-bottom: 8px;
}

.content-card p {
    color: #6b7280;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.booking-table th {
    text-align: left;
    padding: 14px;
    background: #f9fafb;
    font-size: 13px;
    color: #6b7280;
}

.booking-table td {
    padding: 14px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 14px;
}

.status {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.status-confirmed {
    background: #dcfce7;
    color: #166534;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.view-all {
    display: inline-block;
    margin-top: 20px;
    color: #111827;
    font-weight: 600;
    text-decoration: none;
}

@endsection


@section('content')


    <div class="content-card">
        <h1>User Dashboard</h1>

        <p>
            Selamat datang, {{ auth()->user()->name }}
        </p>

        <p>
            Role: {{ auth()->user()->role }}
        </p>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-label">
            Total Kost
        </div>

        <div class="stat-value">
            {{ $totalKosts }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Kamar
        </div>

        <div class="stat-value">
            {{ $totalRooms }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Booking
        </div>

        <div class="stat-value">
            {{ $totalBookings }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Booking Berhasil
        </div>

        <div class="stat-value">
            {{ $confirmedBookings }}
        </div>


    </div>

</div>


<div class="content-card">

    <h1>Selamat datang, {{ auth()->user()->name }}</h1>

    <p>
        Berikut adalah aktivitas booking terbaru di kost Anda.
    </p>


    @if($recentBookings->count())

        <table class="booking-table">

            <thead>

                <tr>
                    <th>Student</th>
                    <th>Kost</th>
                    <th>Kamar</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

            </thead>


            <tbody>

                @foreach($recentBookings as $booking)

                    <tr>

                        <td>
                            <strong>
                                {{ $booking->user->name }}
                            </strong>

                            <br>

                            <small style="color:#6b7280;">
                                {{ $booking->user->email }}
                            </small>
                        </td>


                        <td>
                            {{ $booking->room->kost->name }}
                        </td>


                        <td>
                            {{ $booking->room->room_number }}
                        </td>


                        <td>
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>


                        <td>

                            @if($booking->status === 'confirmed')

                                <span class="status status-confirmed">
                                    Confirmed
                                </span>

                            @elseif($booking->status === 'pending')

                                <span class="status status-pending">
                                    Pending
                                </span>

                            @else

                                {{ ucfirst($booking->status) }}

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        <a
            href="{{ route('owner.bookings.index') }}"
            class="view-all"
        >
            Lihat Semua Booking →
        </a>

    @else

        <div style="
            text-align:center;
            padding:40px 20px;
            color:#6b7280;
        ">
            Belum ada booking.
        </div>

    @endif

</div>

@endsection