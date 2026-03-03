<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'email',
        'phone',
        'move_in_date',
        'move_out_date',
        'id_proof_type',
        'id_proof_number',
        'emergency_contact',
        'status',
        'members_count',
        'notes',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'move_out_date' => 'date',
        'members_count' => 'integer',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}