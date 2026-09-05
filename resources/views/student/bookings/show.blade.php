<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Detail Booking - KosMatch
    </title>
</head>

<body>

<div
    style="
        max-width:800px;
        margin:40px auto;
        font-family:Arial;
    "
>

    <h1>
        Detail Booking
    </h1>

    <br>


    @if (session('success'))

        <div
            style="
                background:#dcfce7;
                color:#166534;
                padding:15px;
                border-radius:8px;
                margin-bottom:20px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    <div
        style="
            background:white;
            border:1px solid #e5e7eb;
            border-radius:12px;
            padding:25px;
        "
    >

        <h2>
            {{ $booking->room->kost->name }}
        </h2>

        <p>
            Kamar {{ $booking->room->room_number }}
        </p>

        <hr style="margin:20px 0;">


        <p>
            <strong>Order ID:</strong>
            {{ $booking->order_id }}
        </p>

        <br>

        <p>
            <strong>Tanggal mulai:</strong>
            {{ $booking->start_date->format('d M Y') }}
        </p>

        <p>
            <strong>Tanggal selesai:</strong>
            {{ $booking->end_date->format('d M Y') }}
        </p>

        <br>

        <p>
            <strong>Total:</strong>
            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
        </p>

        <br>

        <p>
            <strong>Status booking:</strong>
            {{ ucfirst($booking->status) }}
        </p>

        <p>
            <strong>Status pembayaran:</strong>
            {{ ucfirst($booking->payment_status) }}
        </p>


        {{-- NANTI MIDTRANS --}}
        @if ($booking->payment_status === 'pending')

            <br>

            <button
                type="button"
                disabled
                style="
                    padding:12px 20px;
                    border:none;
                    border-radius:8px;
                    background:#4353ff;
                    color:white;
                    cursor:not-allowed;
                "
            >
                Bayar Sekarang
            </button>

            <p style="margin-top:10px;color:#6b7280;">
                Tombol pembayaran akan kita hubungkan
                ke Midtrans pada tahap berikutnya.
            </p>

        @endif

    </div>

</div>

</body>

</html>