<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'walkin_number',
        'insured_name',
        'unit',
        'plate_number',
        'address',
        'contact_number',
        'email',
        'file_path',
        'parts_amount',
        'labor_cost',
        'materials_cost',
        'vat_amount',
        'total_amount',
        'payment_type',
        'status',
        'paid_amount',
        'premium',
        'vat',
        'documentary_stamp_tax',
        'local_gov_tax',
        'amount_due',
        'premium_remarks',
        'payment_terms',
        'payment_method',
        'bank_transfer',
        'bank_transfer_other',
        'reference_number',
        'remarks',
        'rate',
        'walkin_payment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the installments for the walk-in
     */
    public function installments()
    {
        return $this->hasMany(WalkInInstallment::class, 'walkin_id');
    }
}
