<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_number',
        'floor_name',
        'description',
        'total_rooms',
    ];

    protected $casts = [
        'floor_number' => 'integer',
        'total_rooms' => 'integer',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function residents()
    {
        return $this->hasManyThrough(Resident::class, Room::class);
    }
}