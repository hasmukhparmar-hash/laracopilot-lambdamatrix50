<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'visitor_name',
        'visitor_phone',
        'purpose',
        'visit_date',
        'check_in',
        'check_out',
        'vehicle_number',
        'id_proof',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}