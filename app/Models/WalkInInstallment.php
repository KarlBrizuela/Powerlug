<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkInInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'walkin_id',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the walk-in associated with this installment
     */
    public function walkIn()
    {
        return $this->belongsTo(WalkIn::class, 'walkin_id');
    }

    /**
     * Get the user who created this installment
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
