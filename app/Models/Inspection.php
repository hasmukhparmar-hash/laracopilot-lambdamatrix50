<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'inspection_date',
        'chief_complaint', 'diagnosis', 'symptoms',
        'vitals_bp', 'vitals_temp', 'vitals_pulse', 'vitals_weight',
        'notes', 'follow_up_date',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'follow_up_date'  => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'inspection_medicine')
            ->withPivot('dosage', 'duration', 'quantity')
            ->withTimestamps();
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}