<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'policy_id',
        'claim_id',
        'insurance_provider_id',
        'policy_number',
        'insured',
        'gross_premium',
        'net_premium',
        'loa',
        'commission_amount',
        'commission_rate',
        'payment_status',
        'remarks',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'gross_premium' => 'decimal:2',
        'net_premium' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        
    ];

    /**
     * Get the policy associated with this commission.
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    /**
     * Get the claim associated with this commission.
     */
    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    /**
     * Get the insurance provider for this commission.
     */
    public function insuranceProvider()
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

    /**
     * Get the user who created this commission.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this commission.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the status badge color for display.
     */
    public function getStatusColor()
    {
        return match($this->payment_status) {
            'paid' => 'success',
            'partial' => 'warning',
            'pending' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Calculate commission amount based on net premium and commission rate.
     */
    public function calculateCommission()
    {
        return ($this->net_premium * $this->commission_rate) / 100;
    }
}
