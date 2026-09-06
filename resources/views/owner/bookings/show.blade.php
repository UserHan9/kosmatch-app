@php($active = 'booking')

@extends('layouts.app')

@section('title', 'Detail Booking - LuxHome')

@section('page-title', 'Detail Booking')

@section('styles')

.booking-detail {
    max-width: 900px;
}

.detail-card {
    background: white;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    margin-bottom: 20px;
}

.detail-card h2 {
    font-size: 20px;
    margin-bottom: 20px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #f1f1f1;
}

.detail-label {
    color: #6b7280;
}

.detail-value {
    font-weight: 600;
    text-align: right;
}

.back-button {
    display: inline-block;
    padding: 10px 16px;
    background: #f3f4f6;
    color: #111827;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
}

.badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.badge-confirmed {
    background: #dcfce7;
    color: #166534;
}

.badge-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.badge-paid {
    background: #dcfce7;
    color: #166534;
}

.badge-unpaid {
    background: #fef3c7;
    color: #92400e;
}

@endsection

@section('content')

<div class="booking-detail">

    <a
        href="{{ route('owner.bookings.index') }}"
        class="back-button"
    >
        ← Kembali
    </a>

    <br><br>

    <div class="detail-card">

        <h2>Informasi Student</h2>

        <div class="detail-row">
            <span class="detail-label">
                Nama
            </span>

            <span class="detail-value">
                {{ $booking->user->name }}
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">
                Email
            </span>

            <span class="detail-value">
                {{ $booking->user->email }}
            </span>
        </div>

    </div>


    <div class="detail-card">

        <h2>Informasi Booking</h2>

        <div class="detail-row">

            <span class="detail-label">
                Kost
            </span>

            <span class="detail-value">
                {{ $booking->room->kost->name }}
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Kamar
            </span>

            <span class="detail-value">
                {{ $booking->room->room_number }}
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Mulai
            </span>

            <span class="detail-value">
                {{ $booking->start_date->format('d M Y') }}
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Selesai
            </span>

            <span class="detail-value">
                {{ $booking->end_date->format('d M Y') }}
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Total Harga
            </span>

            <span class="detail-value">
                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Order ID
            </span>

            <span class="detail-value">
                {{ $booking->order_id }}
            </span>

        </div>

    </div>


    <div class="detail-card">

        <h2>Status</h2>

        <div class="detail-row">

            <span class="detail-label">
                Status Booking
            </span>

            <span class="detail-value">

                @if($booking->status === 'confirmed')

                    <span class="badge badge-confirmed">
                        Confirmed
                    </span>

                @elseif($booking->status === 'pending')

                    <span class="badge badge-pending">
                        Pending
                    </span>

                @elseif($booking->status === 'cancelled')

                    <span class="badge badge-cancelled">
                        Cancelled
                    </span>

                @else

                    {{ ucfirst($booking->status) }}

                @endif

            </span>

        </div>


        <div class="detail-row">

            <span class="detail-label">
                Status Pembayaran
            </span>

            <span class="detail-value">

                @if($booking->payment_status === 'paid')

                    <span class="badge badge-paid">
                        Lunas
                    </span>

                @elseif($booking->payment_status === 'pending')

                    <span class="badge badge-unpaid">
                        Pending
                    </span>

                @else

                    {{ ucfirst($booking->payment_status) }}

                @endif

            </span>

        </div>


        @if($booking->payment_type)

            <div class="detail-row">

                <span class="detail-label">
                    Metode Pembayaran
                </span>

                <span class="detail-value">
                    {{ strtoupper($booking->payment_type) }}
                </span>

            </div>

        @endif


        @if($booking->paid_at)

            <div class="detail-row">

                <span class="detail-label">
                    Dibayar Pada
                </span>

                <span class="detail-value">
                    {{ $booking->paid_at->format('d M Y H:i') }}
                </span>

            </div>

        @endif

    </div>

</div>

@endsection