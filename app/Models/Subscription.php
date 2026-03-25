<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Subscription model for Via membership tiers.
 * Corresponds to the 'subscriptions' table.
 */
class Subscription extends Model
{
    protected $fillable = [
        'name',
        'price',
        'period',
        'tagline',
        'features',
    ];
}
