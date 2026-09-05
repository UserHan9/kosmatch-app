<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kost_facility', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kost_id')
                ->constrained('kosts')
                ->cascadeOnDelete();

            $table->foreignId('facility_id')
                ->constrained('facilities')
                ->cascadeOnDelete();

            // Status fasilitas pada kost tertentu
            $table->boolean('is_available')
                ->default(false);

            $table->timestamps();

            // Satu fasilitas hanya sekali pada satu kost
            $table->unique([
                'kost_id',
                'facility_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost_facility');
    }
};