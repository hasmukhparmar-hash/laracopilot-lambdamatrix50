<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'specialization', 'email', 'phone',
        'qualification', 'experience_years', 'consultation_fee',
        'active', 'schedule',
    ];

    protected $casts = [
        'active'           => 'boolean',
        'consultation_fee' => 'decimal:2',
        'experience_years' => 'integer',
    ];

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}