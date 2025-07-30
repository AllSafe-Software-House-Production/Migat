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
        'type', 'description', 'travel_company', 'images'
    ];

    protected $casts = [
    'images' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('packages');
    }

}
