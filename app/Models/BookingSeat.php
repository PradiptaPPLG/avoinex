<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_seat_id';
    protected $table = 'booking_seats';

    protected $fillable = [
        'booking_id',
        'flight_seat_price_id',
        'passenger_first_name',
        'passenger_last_name',
        'passenger_passport',
        'passenger_date_of_birth',
        'seat_id',
        'price_at_booking',
        'special_requests',
        'baggage_weight',
        'baggage_price',
        'meal_id',
        'meal_price',
        'has_insurance',
        'insurance_price',
        'is_vip_seat_selection'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function flightSeatPrice()
    {
        return $this->belongsTo(FlightSeatPrice::class, 'flight_seat_price_id', 'flight_seat_price_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id', 'id');
    }

    /**
     * Accessor: full passenger name.
     */
    public function getPassengerNameAttribute()
    {
        return trim(($this->passenger_first_name ?? '') . ' ' . ($this->passenger_last_name ?? ''));
    }
}