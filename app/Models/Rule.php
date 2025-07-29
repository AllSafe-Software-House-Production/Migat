<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['name', 'position', 'email', 'phone', 'role_ids'];

    protected $casts = [
        'role_ids' => 'array',
    ];

    public function getRolesListAttribute()
    {
        return Role::whereIn('id', $this->role_ids ?? [])->get();
    }


}
