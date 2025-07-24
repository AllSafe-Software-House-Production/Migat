<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'name' => $this->name,
            'hotel_id' => $this->hotel_id,
            'room_type' => $this->room_type,
            'space' => $this->space,
            'number_of_beds' => $this->number_of_beds,
            'number_of_adults' => $this->number_of_adults,
            'number_of_children' => $this->number_of_children,
            'room_photos' => $this->getMedia('room_photos')->map->getUrl(),
            'created_at' => $this->created_at,
        ];    
    }
}
