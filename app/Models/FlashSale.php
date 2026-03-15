<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'discount_type',
        'discount_value',
        'start_time',
        'end_time',
        'max_seats',
        'seats_sold',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship with FlightInstance
     */
    public function flightInstance()
    {
        return $this->belongsTo(FlightInstance::class, 'flight_id', 'flight_instance_id');
    }

    /**
     * Scope a query to only include active flash sales.
     */
    public function scopeActive(Builder $query): void
    {
        $now = Carbon::now();
        $query->where('is_active', true)
              ->where('start_time', '<=', $now)
              ->where('end_time', '>=', $now)
              ->whereRaw('seats_sold < max_seats');
    }

    /**
     * Get remaining available seats for this promo.
     */
    public function getRemainingSeats(): int
    {
        return max(0, $this->max_seats - $this->seats_sold);
    }

    /**
     * Calculate discounted price dynamically without altering base_price.
     * 
     * @param float $basePrice
     * @return float
     */
    public function getDiscountedPrice(float $basePrice): float
    {
        if ($this->discount_type === 'percentage') {
            return max(0, $basePrice - ($basePrice * ($this->discount_value / 100)));
        }

        if ($this->discount_type === 'fixed') {
            return max(0, $basePrice - $this->discount_value);
        }

        return $basePrice;
    }
}
