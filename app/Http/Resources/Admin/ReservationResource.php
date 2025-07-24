<?php

namespace App\Http\Resources\Admin;

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
            'user' => new UserResource($this->whenLoaded('user')),
            'room' => new RoomResource($this->whenLoaded('room')),
            'check_in' => $this->check_in->toDateString(),
            'check_out' => $this->check_out->toDateString(),
            'total_price' => $this->total_price,
            'status' => $this->status,
            'source' => $this->source,
            'self_check_in' => $this->self_check_in,
            'self_check_out' => $this->self_check_out,
            'balance' => $this->balance,
            'created_at' => $this->created_at,
        ];    
    }
}
