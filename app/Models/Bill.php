<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'inspection_id', 'bill_number',
        'bill_date', 'subtotal', 'discount', 'total_amount',
        'payment_status', 'payment_method', 'notes',
    ];

    protected $casts = [
        'bill_date'    => 'date',
        'subtotal'     => 'decimal:2',
        'discount'     => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }
}