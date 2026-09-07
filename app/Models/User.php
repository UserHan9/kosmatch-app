<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;



#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function kosts(): HasMany
    {
    return $this->hasMany(Kost::class, 'owner_id');
    }

    public function bookings(): HasMany
    {
    return $this->hasMany(Booking::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function studentConversations(): HasMany
        {
            return $this->hasMany(
                Conversation::class,
                'student_id'
            );
        }

        public function ownerConversations(): HasMany
        {
            return $this->hasMany(
                Conversation::class,
                'owner_id'
            );
        }

        public function sentMessages(): HasMany
        {
            return $this->hasMany(
                Message::class,
                'sender_id'
            );
        }
}
