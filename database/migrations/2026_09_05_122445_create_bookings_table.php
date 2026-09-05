<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

          
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

           
            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

           
            $table->date('start_date');
            $table->date('end_date');

          
            $table->decimal('total_price', 12, 2);

           
            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'completed',
            ])->default('pending');

           
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'expired',
            ])->default('pending');

         
            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_type')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};