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
    ];
}
