<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FlightInstance extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'flight_instance_id';
    protected $table = 'flight_instances';

    protected $fillable = ['schedule_id', 'aircraft_instance_id', 'flight_date', 'is_active'];

    // Tambahkan ini
    protected $dates = ['flight_date'];
    // atau
    protected $casts = [
        'flight_date' => 'date',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class , 'schedule_id', 'schedule_id');
    }

    public function aircraftInstance()
    {
        return $this->belongsTo(AircraftInstance::class , 'aircraft_instance_id', 'aircraft_instance_id');
    }

    public function flightSeatPrices()
    {
        return $this->hasMany(FlightSeatPrice::class , 'flight_instance_id', 'flight_instance_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class , 'flight_instance_id', 'flight_instance_id');
    }

    public function flashSale()
    {
        return $this->hasOne(FlashSale::class, 'flight_id', 'flight_instance_id');
    }

    public function flightInstanceCode()
    {
        if ($this->schedule) {
            return $this->schedule->airline_code . $this->schedule->flight_number;
        }
        return 'FLIGHT-' . $this->flight_instance_id;
    }

    /**
     * Boot the model and ensure related records are removed when a
     * flight instance is deleted. This prevents foreign-key violations
     * for flight_seat_prices and bookings.
     */
    protected static function booted()
    {
        static::deleting(function (FlightInstance $instance) {
            $instance->flightSeatPrices()->delete();
            $instance->bookings()->delete();
        });
    }
}