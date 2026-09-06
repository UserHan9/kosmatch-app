<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kost;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id();

        $totalKosts = Kost::where('owner_id', $ownerId)->count();

        $totalRooms = Room::whereHas('kost', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->count();

        $totalBookings = Booking::whereHas('room.kost', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->count();

        $confirmedBookings = Booking::whereHas('room.kost', function ($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })
            ->where('status', 'confirmed')
            ->count();

        $recentBookings = Booking::with([
            'user',
            'room.kost',
        ])
            ->whereHas('room.kost', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('owner.dashboard', compact(
            'totalKosts',
            'totalRooms',
            'totalBookings',
            'confirmedBookings',
            'recentBookings'
        ));
    }
}