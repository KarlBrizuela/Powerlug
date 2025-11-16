<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Use a different table name to avoid collision with existing 'services' usage.
     */
    protected $table = 'car_services';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'created_by',
    ];
}
