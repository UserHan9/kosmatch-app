<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'payment_status',
        'order_id',
        'snap_token',
        'transaction_id',
        'payment_type',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

   
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}