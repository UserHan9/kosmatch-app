<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Kost $kost)
    {
        $this->authorizeOwner($kost);

        $kost->load('rooms.images');

        return view('owner.rooms.index', compact('kost'));
    }

    public function create(Kost $kost)
    {
        $this->authorizeOwner($kost);

        return view('owner.rooms.create', compact('kost'));
    }

    public function store(Request $request, Kost $kost)
    {
        $this->authorizeOwner($kost);

        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,booked,inactive'],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $room = $kost->rooms()->create([
            'room_number' => $validated['room_number'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Simpan banyak foto kamar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');

                $room->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('owner.kosts.rooms.index', $kost)
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kost $kost, Room $room)
    {
        $this->authorizeOwner($kost);

        abort_unless($room->kost_id === $kost->id, 404);

        $room->load('images');

        return view('owner.rooms.edit', compact('kost', 'room'));
    }

    public function update(Request $request, Kost $kost, Room $room)
    {
        $this->authorizeOwner($kost);

        abort_unless($room->kost_id === $kost->id, 404);

        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,booked,inactive'],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $room->update([
            'room_number' => $validated['room_number'],
            'price' => $validated['price'],
            'status' => $validated['status'],
        ]);

        // Tambahkan foto baru tanpa menghapus foto lama
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');

                $room->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('owner.kosts.rooms.index', $kost)
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Kost $kost, Room $room)
    {
        $this->authorizeOwner($kost);

        abort_unless($room->kost_id === $kost->id, 404);

        // Hapus semua foto kamar
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $room->delete();

        return redirect()
            ->route('owner.kosts.rooms.index', $kost)
            ->with('success', 'Kamar berhasil dihapus.');
    }

    private function authorizeOwner(Kost $kost): void
    {
        abort_unless(
            $kost->owner_id === auth()->id(),
            403
        );
    }
}