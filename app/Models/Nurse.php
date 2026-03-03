<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'shift', 'department', 'active', 'permissions',
    ];

    protected $casts = [
        'active'      => 'boolean',
        'permissions' => 'array',
    ];
}