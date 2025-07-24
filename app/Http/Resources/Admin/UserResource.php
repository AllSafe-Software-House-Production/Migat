<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'extra_email' => $this->extra_email,
            'role' => $this->role,
            'nickname' => $this->nickname,
            'country' => $this->country,
            'language' => $this->language,
            'timezone' => $this->timezone,
            'gender' => $this->gender,
            'photo' => $this->getFirstMediaUrl('user_photo') ?? null,
            'permissions' => $this->rule?->roles->pluck('route'),
            'token' => $this->when(isset($this->token), $this->token),
        ];
    }
}
