<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'price' => $this->price,
            'from' => $this->from,
            'to' => $this->to,
            'transportation' => $this->transportation,
            'trip_type' => $this->trip_type,
            'images' => $this->getMedia('packages')->map(function ($media) {
                return $media->getUrl();
            }),
            'type' => $this->type,
            'description' => $this->description,
            'travel_company' => $this->travel_company,
            'created_at' => $this->created_at,
        ];    
    }
}
