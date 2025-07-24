<?php

namespace App\Http\Resources\Admin;

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
            'image' => $this->getFirstMediaUrl('religious_image') ?? null,
            'phone' => $this->phone,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'price' => $this->price,
            'what_will_you_do' => $this->what_will_you_do,
            'photos' => $this->getMedia('religious_tour')->map(fn($m) => $m->getUrl()) ?? [],
            'created_at' => $this->created_at,
        ];    
    }
}
