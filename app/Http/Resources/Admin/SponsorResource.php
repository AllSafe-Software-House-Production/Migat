<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
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
            'about' => $this->about,
            'photo' => $this->getFirstMediaUrl('sponsors') ?? null,
            'location' => $this->location,
            'date' => $this->date,
            'created_at' => $this->created_at,
        ];    
    }
}
