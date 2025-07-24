<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'type' => $this->type,
            'user' => new UserResource($this->whenLoaded('user')),
            'package' => new PackageResource($this->whenLoaded('package')),
            'details' => [
                // Return fields based on type
                'no_of_people' => $this->no_of_people,
                'hotel' => $this->hotel,
                'date_of_reservation' => $this->date_of_reservation,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'payment_status' => $this->payment_status,
                'room_type' => $this->room_type,
                'full_name' => $this->full_name,
                'passport_number' => $this->passport_number,
                'passport_file' => $this->passport_file ? asset('storage/' . $this->passport_file) : null,
                'religious_id' => $this->religious_id,
                'religious_name' => $this->religious_name,
                'tour_type' => $this->tour_type,
                'no_of_members' => $this->no_of_members,
                'transfer_date' => $this->transfer_date,
                'transfer_time' => $this->transfer_time,
                'transfer_payment_status' => $this->transfer_payment_status,
                'religious_guide' => $this->religious_guide,
            ],
            'created_at' => $this->created_at,
        ];    
    }
}
