<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightMeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_instance_id',
        'meal_id',
    ];

    public function flightInstance()
    {
        return $this->belongsTo(FlightInstance::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
