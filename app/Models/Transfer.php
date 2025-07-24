<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'user_id', 'pickup_type', 'destination', 'status', 'scheduled_at', 'price', 'paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
