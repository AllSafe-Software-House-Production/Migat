<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AirportTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver_name' => $this->driver_name,
            'car_plate_number' => $this->car_plate_number,
            'whatsapp_number' => $this->whatsapp_number,
            'type_of_car' => $this->type_of_car,
            'created_at' => $this->created_at,
        ];    
    }
}
