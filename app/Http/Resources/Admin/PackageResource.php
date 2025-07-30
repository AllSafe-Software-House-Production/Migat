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
            'hotel' => [
                    'no_of_days' => $this->no_of_days,
                    'hotel_location' => $this->hotel_location,
                    'hotel_name' => $this->hotel_name,
                    'room_type' => $this->room_type,
                    'services' => $this->services,
                    'hotel_price' => $this->hotel_price,
                    'hotel_trip_type' => $this->hotel_trip_type,
                    'hotel_from' => $this->hotel_from,
                    'hotel_to' => $this->hotel_to,
                    'hotel_type' => $this->hotel_type,
                    'hotel_images' => $this->getMedia('hotel_images')->map(function ($media) {
                        return $media->getUrl() ?? [];
                    }),
                    'short_video' => $this->getMedia('short_video')->map(function ($media) {
                        return $media->getUrl() ?? null;
                    }),
                ],


            'created_at' => $this->created_at,
        ];
    }
}
