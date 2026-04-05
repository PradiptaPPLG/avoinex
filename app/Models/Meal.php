<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_usd',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price_usd' => 'float',
        'is_active' => 'boolean',
    ];

    public function flightInstances()
    {
        return $this->belongsToMany(FlightInstance::class, 'flight_meals');
    }
}
