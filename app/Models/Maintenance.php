<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'resident_id',
        'title',
        'description',
        'category',
        'priority',
        'status',
        'scheduled_date',
        'completed_date',
        'cost',
        'assigned_to',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}