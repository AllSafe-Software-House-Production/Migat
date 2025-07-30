<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Package extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'price', 'from', 'to', 'transportation', 'trip_type',
        'type', 'description', 'travel_company', 'images',
        'no_of_days', 'hotel_location', 'hotel_name', 'room_type', 'services', 'short_video', 'hotel_price', 'hotel_trip_type', 'hotel_from', 'hotel_to', 'hotel_type', 'hotel_images'
    ];

    protected $casts = [
        'images' => 'array',
        'services' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('packages');
        $this->addMediaCollection('hotel_images');
        $this->addMediaCollection('short_video');
    }

}
