<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('kost_id')
                ->constrained('kosts')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'student_id',
                'owner_id',
                'kost_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};