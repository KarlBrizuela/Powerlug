<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'email',
        'phone',
        'address',
        'city',
        'province',
        'postalCode',
        'tin',
        'make_model',
        'plate_no',
        'model_year',
        'color'
    ];
}
