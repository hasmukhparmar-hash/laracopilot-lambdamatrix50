<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id', 'quantity', 'reorder_level',
        'expiry_date', 'batch_number', 'purchase_price', 'supplier',
    ];

    protected $casts = [
        'expiry_date'    => 'date',
        'purchase_price' => 'decimal:2',
        'quantity'       => 'integer',
        'reorder_level'  => 'integer',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }
}