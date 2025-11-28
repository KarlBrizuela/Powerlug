<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'invoice_number',
        'policy_number',
        'claim_number',
        'collection_amount',
        'loa_amount',
        'payment_method',
        'collection_status',
        'billing_status',
        'bank_name',
        'collection_date',
        'loa'
    ];

    protected $casts = [
        'collection_date' => 'date',
        'collection_amount' => 'decimal:2',
        'loa_amount' => 'decimal:2'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
