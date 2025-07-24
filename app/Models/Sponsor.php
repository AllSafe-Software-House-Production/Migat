<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Sponsor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'sponsors';

    protected $guarded = [];

    protected $fillable = ['about', 'location', 'date'];
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sponsors');

    }
    
}
