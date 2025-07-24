<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable , InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'role',
        'otp_code', 'otp_expires_at',
        'gender', 'nickname', 'country', 'language', 'timezone','extra_email','rule_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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


    public function roomRequests()
    {
        return $this->hasMany(RoomRequest::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user_photo');

    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function favoriteHotels()
    {
        return $this->hasManyThrough(Hotel::class, Favorite::class, 'user_id', 'id', 'id', 'hotel_id');
    }
}
