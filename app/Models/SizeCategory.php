<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeCategory extends Model
{
    use HasFactory;

    protected $table = 'size_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the services that belong to this size category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'size_category_id');
    }
}
