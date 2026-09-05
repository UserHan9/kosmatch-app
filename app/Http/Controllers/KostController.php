<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    
    public function index()
    {
        $kosts = Kost::where('owner_id', Auth::id())
            ->latest()
            ->get();

        return view('owner.kosts.index', compact('kosts'));
    }

   
    public function create()
    {
        $facilities = Facility::all();

        return view('owner.kosts.create', compact('facilities'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'price' => ['required', 'numeric', 'min:0'],
            'gender_type' => ['required', 'in:male,female,mixed'],
            'status' => ['required', 'in:active,inactive'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ]);

       
        $imagePath = $request->file('image')->store('kosts', 'public');

       
        $kost = Kost::create([
            'owner_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'city' => $validated['city'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'price' => $validated['price'],
            'gender_type' => $validated['gender_type'],
            'status' => $validated['status'],
        ]);

       
        $facilityData = [];

        foreach ($validated['facilities'] ?? [] as $facilityId) {
            $facilityData[$facilityId] = [
                'is_available' => true,
            ];
        }

        $kost->facilities()->sync($facilityData);

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Kost berhasil ditambahkan.');
    }

   
    public function show(Kost $kost)
    {
        $this->authorizeOwner($kost);

        $kost->load('facilities', 'rooms');

        return view('owner.kosts.show', compact('kost'));
    }

   
    public function edit(Kost $kost)
    {
        $this->authorizeOwner($kost);

        $facilities = Facility::all();

        $kost->load('facilities');

        return view('owner.kosts.edit', compact('kost', 'facilities'));
    }

  
    public function update(Request $request, Kost $kost)
    {
        $this->authorizeOwner($kost);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'price' => ['required', 'numeric', 'min:0'],
            'gender_type' => ['required', 'in:male,female,mixed'],
            'status' => ['required', 'in:active,inactive'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
        ]);

      
        if ($request->hasFile('image')) {
            if ($kost->image) {
                Storage::disk('public')->delete($kost->image);
            }

          
            $validated['image'] = $request->file('image')
                ->store('kosts', 'public');
        }

        unset($validated['facilities']);

        $kost->update($validated);

        
        $facilityData = [];

        foreach ($request->input('facilities', []) as $facilityId) {
            $facilityData[$facilityId] = [
                'is_available' => true,
            ];
        }

        $kost->facilities()->sync($facilityData);

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Kost berhasil diperbarui.');
    }

   
    public function destroy(Kost $kost)
    {
        $this->authorizeOwner($kost);

     
        if ($kost->image) {
            Storage::disk('public')->delete($kost->image);
        }

        $kost->delete();

        return redirect()
            ->route('owner.kosts.index')
            ->with('success', 'Kost berhasil dihapus.');
    }

    
    private function authorizeOwner(Kost $kost): void
    {
        abort_unless(
            $kost->owner_id === Auth::id(),
            403
        );
    }
}