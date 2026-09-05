<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function kosts(): BelongsToMany
    {
        return $this->belongsToMany(
            Kost::class,
            'kost_facility'
        )
        ->withPivot('is_available')
        ->withTimestamps();
    }
}