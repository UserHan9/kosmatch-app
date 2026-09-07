@php($active = 'booking')

@extends('layouts.app')

@section('title', 'Booking - KosMatch')

@section('page-title', 'Booking')

@section('styles')

.booking-header {
    margin-bottom: 24px;
}

.booking-header h1 {
    font-size: 24px;
    margin-bottom: 6px;
}

.booking-header p {
    color: #6b7280;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
}

.booking-table th {
    text-align: left;
    padding: 14px 16px;
    background: #f9fafb;
    font-size: 13px;
    color: #6b7280;
}

.booking-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 14px;
}

.booking-table tr:hover {
    background: #fafafa;
}

.student-name {
    font-weight: 600;
    color: #111827;
}

.kost-name {
    font-weight: 600;
}

.room-number {
    color: #6b7280;
    margin-top: 3px;
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

.badge-completed {
    background: #dbeafe;
    color: #1e40af;
}

.badge-paid {
    background: #dcfce7;
    color: #166534;
}

.badge-unpaid {
    background: #fef3c7;
    color: #92400e;
}

.detail-button {
    display: inline-block;
    padding: 8px 14px;
    background: #111827;
    color: white;
    text-decoration: none;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
}

.detail-button:hover {
    background: #374151;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

@endsection

@section('content')

<div class="content-card">

    <div class="booking-header">
        <h1>Booking Masuk</h1>

        <p>
            Daftar booking dari student untuk kamar di kost Anda.
        </p>
    </div>

    @if($bookings->count() > 0)

        <div style="overflow-x:auto;">

            <table class="booking-table">

                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Kost</th>
                        <th>Kamar</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($bookings as $booking)

                        <tr>

                            <td>
                                <div class="student-name">
                                    {{ $booking->user->name }}
                                </div>

                                <div style="color:#6b7280; font-size:12px;">
                                    {{ $booking->user->email }}
                                </div>
                            </td>

                            <td>
                                <div class="kost-name">
                                    {{ $booking->room->kost->name }}
                                </div>

                                <div style="color:#6b7280; font-size:12px;">
                                    {{ $booking->room->kost->city }}
                                </div>
                            </td>

                            <td>
                                <div class="room-number">
                                    Kamar {{ $booking->room->room_number }}
                                </div>
                            </td>

                            <td>
                                {{ $booking->start_date->format('d M Y') }}

                                <br>

                                <span style="color:#6b7280;">
                                    sampai
                                </span>

                                <br>

                                {{ $booking->end_date->format('d M Y') }}
                            </td>

                            <td>
                                <strong>
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </strong>
                            </td>

                            <td>

                                @if($booking->payment_status === 'paid')

                                    <span class="badge badge-paid">
                                        Lunas
                                    </span>

                                @elseif($booking->payment_status === 'pending')

                                    <span class="badge badge-unpaid">
                                        Pending
                                    </span>

                                @elseif($booking->payment_status === 'failed')

                                    <span class="badge badge-cancelled">
                                        Gagal
                                    </span>

                                @elseif($booking->payment_status === 'expired')

                                    <span class="badge badge-cancelled">
                                        Expired
                                    </span>

                                @endif

                            </td>

                            <td>

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

                                @elseif($booking->status === 'completed')

                                    <span class="badge badge-completed">
                                        Completed
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('owner.bookings.show', $booking) }}"
                                    class="detail-button"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty-state">

            <h3>Belum ada booking</h3>

            <p>
                Booking dari student akan muncul di halaman ini.
            </p>

        </div>

    @endif

</div>

@endsection