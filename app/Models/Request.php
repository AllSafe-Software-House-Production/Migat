<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Request extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'type', 'user_id',
        'no_of_people', 'hotel', 'date_of_reservation', 'start_date', 'end_date', 'payment_status', 'room_type',
        'package_id', 'full_name', 'passport_number', 'passport_file',
        'religious_id', 'religious_name', 'tour_type', 'no_of_members', 'transfer_date', 'transfer_time', 'transfer_payment_status', 'religious_guide',
        'phone'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
        $this->addMediaCollection('passport')->singleFile();
    }
}
