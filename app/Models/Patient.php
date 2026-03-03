<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'name', 'age', 'gender', 'phone', 'email',
        'address', 'blood_group', 'dob', 'emergency_contact',
        'allergies', 'chronic_diseases', 'referred_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'age' => 'integer',
    ];

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function getIsRepeatedAttribute(): bool
    {
        return $this->inspections()->count() > 1;
    }
}