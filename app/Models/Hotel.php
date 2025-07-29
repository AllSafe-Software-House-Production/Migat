<?php

namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'location', 'availability', 'description', 'photos',
        'distance_from_haram', 'special_check_in_instructions', 'access_methods',
        'pets', 'commission', 'commercial_register', 'tourism_license',
        'utility_bill', 'owner_id', 'ipan', 'visa', 'number_of_rooms',
        'phone', 'email', 'service', 'policy', 'hotel_link',
    ];

    protected $casts = [
        'photos' => 'array',
        // 'service_ids' => 'array',
        // 'policy_ids' => 'array',
        'availability' => 'boolean',
    ];
    

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // public function services()
    // {
    //     return $this->hasMany(Service::class, 'id', 'service_ids');
    // }

    // public function policies()
    // {
    //     return $this->hasMany(Policy::class, 'id', 'policy_ids');
    // }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('utility_bill');

    }
}