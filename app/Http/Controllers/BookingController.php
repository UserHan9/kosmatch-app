<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   
    public function index()
    {
        $bookings = Booking::with([
                'room.kost'
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'student.bookings.index',
            compact('bookings')
        );
    }

   
    public function create(Room $room)
    {
       
        abort_unless(
            $room->status === 'available',
            403,
            'Kamar tidak tersedia.'
        );

        $room->load([
            'kost',
            'images',
        ]);

        return view(
            'student.bookings.create',
            compact('room')
        );
    }

    
    public function store(
        Request $request,
        Room $room
    ) {
       
        abort_unless(
            $room->status === 'available',
            403,
            'Kamar tidak tersedia.'
        );

        $validated = $request->validate([
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],
        ]);

       
        $conflict = Booking::where('room_id', $room->id)
            ->whereIn('status', [
                'pending',
                'confirmed',
            ])
            ->where(function ($query) use ($validated) {

                $query
                    ->whereBetween(
                        'start_date',
                        [
                            $validated['start_date'],
                            $validated['end_date'],
                        ]
                    )
                    ->orWhereBetween(
                        'end_date',
                        [
                            $validated['start_date'],
                            $validated['end_date'],
                        ]
                    )
                    ->orWhere(function ($query) use ($validated) {

                        $query
                            ->where(
                                'start_date',
                                '<=',
                                $validated['start_date']
                            )
                            ->where(
                                'end_date',
                                '>=',
                                $validated['end_date']
                            );
                    });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors([
                    'start_date' =>
                        'Kamar sudah memiliki booking pada periode tersebut.',
                ])
                ->withInput();
        }

       
        $startDate = \Carbon\Carbon::parse(
            $validated['start_date']
        );

        $endDate = \Carbon\Carbon::parse(
            $validated['end_date']
        );

        $months = max(
            1,
            $startDate->diffInMonths($endDate)
        );

        $totalPrice = $room->price * $months;

       
        $orderId =
            'KOSMATCH-' .
            now()->format('YmdHis') .
            '-' .
            auth()->id() .
            '-' .
            $room->id;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'room_id' => $room->id,

            'start_date' =>
                $validated['start_date'],

            'end_date' =>
                $validated['end_date'],

            'total_price' => $totalPrice,

            'status' => 'pending',

            'payment_status' => 'pending',

            'order_id' => $orderId,
        ]);

        return redirect()
            ->route(
                'student.bookings.show',
                $booking
            )
            ->with(
                'success',
                'Booking berhasil dibuat. Silakan lanjutkan pembayaran.'
            );
    }

    
    public function show(Booking $booking)
    {
       
        abort_unless(
            $booking->user_id === auth()->id(),
            403
        );

        $booking->load([
            'room.kost',
            'room.images',
        ]);

        return view(
            'student.bookings.show',
            compact('booking')
        );
    }
}