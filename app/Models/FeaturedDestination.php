<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedDestination extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'origin_iata',
        'destination_iata',
        'starting_price_usd',
        'date_range',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starting_price_usd' => 'decimal:2',
    ];
}
