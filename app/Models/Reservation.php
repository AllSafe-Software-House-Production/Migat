<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Reservation extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'user_id', 'room_id', 'check_in', 'check_out', 'total_price', 'status',
        'source', 'self_check_in', 'self_check_out', 'balance',
        'name', 'email', 'phone', 'adults', 'children', 'country', 'notes',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'self_check_in' => 'boolean',
        'self_check_out' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
