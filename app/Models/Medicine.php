<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'generic_name', 'category', 'manufacturer',
        'unit_price', 'unit', 'description', 'side_effects',
        'contraindications', 'requires_prescription',
    ];

    protected $casts = [
        'unit_price'             => 'decimal:2',
        'requires_prescription'  => 'boolean',
    ];

    public function stock()
    {
        return $this->hasOne(MedicineStock::class);
    }

    public function inspections()
    {
        return $this->belongsToMany(Inspection::class, 'inspection_medicine')
            ->withPivot('dosage', 'duration', 'quantity')
            ->withTimestamps();
    }
}