<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReligiousTourResource extends JsonResource
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
            'share_tour' => $this->share_tour,
            'description' => $this->description,
            'image' => $this->image,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'price' => $this->price,
            'what_will_you_do' => $this->what_will_you_do,
            'media_url' => $this->getFirstMediaUrl('religious_tour'),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
