<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'room_number',
        'room_type',
        'area_sqft',
        'monthly_rent',
        'status',
        'description',
    ];

    protected $casts = [
        'area_sqft' => 'decimal:2',
        'monthly_rent' => 'decimal:2',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function complaints()
    {
        return $this->hasManyThrough(Complaint::class, Resident::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'occupied' => 'green',
            'vacant' => 'blue',
            'maintenance' => 'yellow',
            default => 'gray',
        };
    }
}