<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_claim',
        'client_name',
        'insurance_provider_id',
        'policy_id',
        'policy_number',
        'claim_number',
        'loa_amount',
        'deductible_participation',
        'file_path',
        'total_amount',
        'admin_status',
        'superadmin_status',
        'created_by',
    ];

    protected $casts = [
        'date_of_claim' => 'date',
        'loa_amount' => 'decimal:2',
        'deductible_participation' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the insurance provider for this claim.
     */
    public function insuranceProvider()
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

    /**
     * Get the policy for this claim.
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    /**
     * Get the user who created this claim.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate a unique claim number.
     */
    public static function generateClaimNumber()
    {
        $year = date('Y');
        $lastClaim = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastClaim && $lastClaim->claim_number) {
            // Extract the numeric part and increment
            preg_match('/(\d+)$/', $lastClaim->claim_number, $matches);
            $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        } else {
            $nextNumber = 1;
        }
        
        return 'CLM-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the badge color for admin status.
     */
    public function getAdminStatusColor()
    {
        return match($this->admin_status) {
            'billed' => 'success',
            'pending' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Get the badge color for superadmin status.
     */
    public function getSuperadminStatusColor()
    {
        return match($this->superadmin_status) {
            'cleared' => 'info',
            'deposited' => 'success',
            default => 'secondary'
        };
    }
}
