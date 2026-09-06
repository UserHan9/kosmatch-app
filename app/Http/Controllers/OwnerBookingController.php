<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class OwnerBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'user',
            'room.kost',
        ])
            ->whereHas('room.kost', function ($query) {
                $query->where('owner_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('owner.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'user',
            'room.kost',
            'room.images',
        ]);

        abort_unless(
            $booking->room->kost->owner_id === Auth::id(),
            403
        );

        return view('owner.bookings.show', compact('booking'));
    }
}