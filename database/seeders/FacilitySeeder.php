<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'WiFi',
                'description' => 'Koneksi internet tersedia di kost.',
            ],
            [
                'name' => 'AC',
                'description' => 'Air conditioner tersedia di kamar.',
            ],
            [
                'name' => 'Parkir',
                'description' => 'Area parkir tersedia untuk penghuni.',
            ],
            [
                'name' => 'Laundry',
                'description' => 'Fasilitas laundry tersedia.',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}