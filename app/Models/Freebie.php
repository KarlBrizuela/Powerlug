<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freebie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'schedule_type',
        'schedule_value',
        'unit',
        'service',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'schedule_value' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];
}
