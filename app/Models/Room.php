<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Room extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'hotel_id',
        'room_type',
        'space',
        'number_of_beds',
        'number_of_adults',
        'number_of_children',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAvailable($query)
    {
        $query->whereDoesntHave('reservations', function ($q) {
            $q->where('status', 'confirmed')
            ->whereDate('check_out', '>=', now()->toDateString());
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('room_photos');
    }
}
