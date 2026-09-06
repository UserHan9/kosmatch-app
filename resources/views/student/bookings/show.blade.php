<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"
    ></script>

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
        id="pay-button"
        style="
            padding:12px 20px;
            border:none;
            border-radius:8px;
            background:#4353ff;
            color:white;
            cursor:pointer;
        "
    >
        Bayar Sekarang
    </button>

    @endif

    </div>

</div>

@if ($booking->payment_status === 'pending')

<script>
    document
        .getElementById('pay-button')
        .addEventListener('click', async function () {

            const button = this;

            button.disabled = true;
            button.innerText = 'Memproses...';

            try {

                const response = await fetch(
                    "{{ route(
                        'student.bookings.payment.token',
                        $booking
                    ) }}"
                );

               const rawText = await response.text();

                // buang karakter apapun sebelum '{' pertama (mis. komentar HTML nyasar)
                const jsonStart = rawText.indexOf('{');
                const cleanJson = jsonStart >= 0 ? rawText.slice(jsonStart) : rawText;

                const data = JSON.parse(cleanJson);

                if (!response.ok) {
                    throw new Error(
                        data.message ||
                        'Gagal membuat pembayaran.'
                    );
                }

                window.snap.pay(
                    data.snap_token,
                    {
                        onSuccess: function (result) {

                            window.location.reload();
                        },

                        onPending: function (result) {

                            window.location.reload();
                        },

                        onError: function (result) {

                            alert(
                                'Pembayaran gagal.'
                            );

                            button.disabled = false;
                            button.innerText =
                                'Bayar Sekarang';
                        },

                        onClose: function () {

                            button.disabled = false;
                            button.innerText =
                                'Bayar Sekarang';
                        }
                    }
                );

            } catch (error) {

                console.error(error);

                alert(
                    error.message ||
                    'Terjadi kesalahan.'
                );

                button.disabled = false;
                button.innerText =
                    'Bayar Sekarang';
            }

        });
</script>

@endif

</body>

</html>