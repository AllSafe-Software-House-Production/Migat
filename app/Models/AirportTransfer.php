<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirportTransfer extends Model
{
        protected $fillable = [
        'driver_name',
        'car_plate_number',
        'whatsapp_number',
        'type_of_car',
    ];
}
