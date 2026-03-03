<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FlightSeatPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'flight_seat_price_id';
    protected $table = 'flight_seat_prices'; // TAMBAH INI

    protected $fillable = ['flight_instance_id', 'seat_id', 'price_usd', 'is_available'];

    public function flightInstance()
    {
        return $this->belongsTo(FlightInstance::class, 'flight_instance_id', 'flight_instance_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'flight_seat_price_id', 'flight_seat_price_id');
    }
}