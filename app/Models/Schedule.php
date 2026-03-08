<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';
    protected $fillable = [
        'flight_number',
        'airline_code',
        'origin_iata_code',
        'destination_iata_code',
        'departure_time_gmt',
        'arrival_time_gmt',
        'duration_minutes',
        'base_price_usd',
        'effective_from',
        'effective_to',
        'is_daily',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'is_active',
    ];

    public function originAirport()
    {
        return $this->belongsTo(Airport::class , 'origin_iata_code', 'iata_code');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class , 'destination_iata_code', 'iata_code');
    }

    public function flightInstances()
    {
        return $this->hasMany(FlightInstance::class , 'schedule_id');
    }

    // TAMBAHKAN INI:
    public function airline()
    {
        return $this->belongsTo(Airline::class , 'airline_code', 'airline_code');
    }
}