<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_active'
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function getFormattedCommissionRateAttribute()
    {
        return number_format($this->commission_rate, 2) . '%';
    }
}
