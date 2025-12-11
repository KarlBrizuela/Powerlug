<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'make_model',
        'plate_number',
        'model_year',
        'color'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
