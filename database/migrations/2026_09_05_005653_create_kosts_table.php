<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();

            // Owner pemilik kost
            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Informasi kost
            $table->string('name');
            $table->text('description')->nullable();

            // 1 gambar cover wajib
            $table->string('image');

            // Lokasi
            $table->string('city');
            $table->text('address');

            // Koordinat lokasi
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Harga kost
            $table->decimal('price', 12, 2);

            // Jenis penghuni
            $table->enum('gender_type', [
                'male',
                'female',
                'mixed'
            ]);

            // Status kost
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};