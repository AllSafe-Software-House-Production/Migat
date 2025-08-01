<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'route',
    ];

    public function rules()
    {
        return $this->belongsToMany(Rule::class);
    }
}
