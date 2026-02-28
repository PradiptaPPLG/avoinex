<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'client_id',
        'flight_instance_id',
        'total_price_usd',
        'booking_status',
        'payment_status',
        'expires_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    public function flightInstance()
    {
        return $this->belongsTo(FlightInstance::class, 'flight_instance_id', 'flight_instance_id');
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class, 'booking_id', 'booking_id');
    }
}