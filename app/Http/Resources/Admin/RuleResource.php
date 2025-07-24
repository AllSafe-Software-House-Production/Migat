<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RuleResource extends JsonResource
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
            'position' => $this->position,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_ids' => $this->role_ids,
            'roles' => RoleResource::collection($this->whenLoaded('roles')) ?? [],
        ];    
    }
}
