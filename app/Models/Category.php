<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Category model for the store.
 * Categories are admin-managed and linked to products.
 */
class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }
}
