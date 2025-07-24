<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;

class ReligiousTour extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'share_tour', 'description', 'image', 'phone', 'email', 'whatsapp',
        'price', 'what_will_you_do',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('religious_tour');
    }
}
