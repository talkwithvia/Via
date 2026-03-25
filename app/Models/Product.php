<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Product model for the Via store.
 * Corresponds to the 'products' table.
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'status',
    ];
}
