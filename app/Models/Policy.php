<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'policy_number',
        'client_id',
        'insurance_provider_id',
        'client_name',
        'address',
        'email',
        'contact_number',
        'make_model',
        'plate_number',
        'model_year',
        'color',
        'coverage_amount',
        'premium',
        'policy_type',
        'start_date',
        'end_date',
        'status',
        'expiration_status',
        'remarks',
        'payment_method',
        'billing_status',
        'created_by',
        'updated_by',
        'insurance_provider',
        'issue_date',
        'coverage_from',
        'coverage_to',
        'chassis_number',
        'engine_number',
        'mv_file_number',
        'mortgage',
        'freebie',
        'walkin_date',
        'walkin_file',
        'estimate_amount',
        'size',
        'services',
        'service_payment_dues',
        'rate',
        'walkin_payment',
        'payment_terms',
        'paid_amount',
        'bank_transfer',
        'additional_freebie',
        'reference_number',
        'vat',
        'documentary_stamp_tax',
        'local_gov_tax',
        'amount_due',
        'coc_vp',
        'premium_remarks',
        'policy_file',
        'paid_services',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'coverage_amount' => 'decimal:2',
        'premium' => 'decimal:2',
        // Cast services (checkbox array) to array so it's stored as JSON in DB safely
        'services' => 'array',
        'service_payment_dues' => 'array',
        'paid_services' => 'array',
    ];

    /**
     * Get the client that owns this policy.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the insurance provider for this policy.
     */
    public function insuranceProvider()
    {
        return $this->belongsTo(InsuranceProvider::class);
    }

    /**
     * Get the user who created this policy.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this policy.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope to get active policies.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get paid policies.
     */
    public function scopePaid($query)
    {
        return $query->where('billing_status', 'paid');
    }

    /**
     * Scope to get unpaid policies.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('billing_status', 'unpaid');
    }

    /**
     * Get installments for this policy.
     */
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
