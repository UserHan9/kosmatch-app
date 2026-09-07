<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kost extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'image',
        'city',
        'address',
        'latitude',
        'longitude',
        'price',
        'gender_type',
        'status',
    ];
    public function conversations(): HasMany
    {
    return $this->hasMany(Conversation::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            Facility::class,
            'kost_facility'
        )
        ->withPivot('is_available')
        ->withTimestamps();
    }
}