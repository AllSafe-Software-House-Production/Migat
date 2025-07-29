<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'location' => $this->location,
            'available_rooms_count' => $this->available_rooms_count ?? 0,
            'availability' => $this->availability,
            'description' => $this->description,
            'distance_from_haram' => $this->distance_from_haram,
            'special_check_in_instructions' => $this->special_check_in_instructions,
            'access_methods' => $this->access_methods,
            'pets' => $this->pets,
            'commission' => $this->commission,
            'commercial_register' => $this->commercial_register,
            'tourism_license' => $this->tourism_license,
            'utility_bill' => $this->getFirstMediaUrl('utility_bill') ?? null,
            'owner_id' => $this->owner_id,
            'owner_name' => $this->owner->name,
            'ipan' => $this->ipan,
            'visa' => $this->visa,
            'number_of_rooms' => $this->number_of_rooms,
            'hotel_link' => $this->hotel_link,
            'phone' => $this->phone,
            'email' => $this->email,
            'policy' => $this->policy,
            'service' => $this->service,
            // 'service_ids' => $this->service_ids,
            // 'policy_ids' => $this->policy_ids,
            'images' => $this->getMedia('images')->map->getUrl() ?? [],
            'created_at' => $this->created_at,
        ];    
    }
}
