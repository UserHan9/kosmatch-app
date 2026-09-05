<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class StudentKostController extends Controller
{
    /**
     * Menampilkan semua kost aktif.
     */
    public function index(Request $request)
    {
        $query = Kost::with([
            'facilities',
            'rooms'
        ])
        ->where('status', 'active');

        // Search nama kost
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kota
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter gender
        if ($request->filled('gender_type')) {
            $query->where('gender_type', $request->gender_type);
        }

        // Filter harga maksimal
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $kosts = $query
            ->latest()
            ->get();

        $cities = Kost::where('status', 'active')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view(
            'student.kosts.index',
            compact('kosts', 'cities')
        );
    }

    /**
     * Detail kost.
     */
    public function show(Kost $kost)
    {
        abort_unless(
            $kost->status === 'active',
            404
        );

        $kost->load([
            'facilities',
            'rooms.images'
        ]);

        return view(
            'student.kosts.show',
            compact('kost')
        );
    }
}