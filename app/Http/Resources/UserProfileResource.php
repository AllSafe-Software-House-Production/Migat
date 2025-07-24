<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'extra_email' => $this->extra_email,
            'phone'    => $this->phone,
            'photo' => $this->getFirstMediaUrl('user_photo') ?? null,
            // 'role'     => $this->role,
            'gender'   => $this->gender,
            'nickname' => $this->nickname,
            'country'  => $this->country,
            'language' => $this->language,
            'timezone' => $this->timezone,
        ];   
    }
}
