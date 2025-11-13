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
        'claim_number',
        'loa_amount',
        'participation_amount',
        'deductible',
        'file_path',
        'parts',
        'labor_cost',
        'materials',
        'vat',
        'total_amount',
        'created_by',
    ];

    protected $casts = [
        'date_of_claim' => 'date',
        'parts' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'materials' => 'decimal:2',
        'vat' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
}
