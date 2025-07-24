<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'check_in' => $this->check_in?->toDateString(),
            'check_out' => $this->check_out?->toDateString(),
            'adults' => $this->adults,
            'children' => $this->children,
            'country' => $this->country,
            'notes' => $this->notes,
            'room_id' => $this->room_id,
            'user_id' => $this->user_id,
            'id_document_url' => $this->getFirstMediaUrl('id_documents'),
            'passport_url' => $this->getFirstMediaUrl('passport_documents'),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];    
    }
}
