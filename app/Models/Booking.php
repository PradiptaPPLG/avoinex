<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'booking_id';
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'client_id',
        'flight_instance_id',
        'total_price_usd',
        'booking_status',
        'payment_status',
        'expires_at',
        'notes',
        'refund_reason',
        'refund_requested_at',
        'refund_amount_usd',
        'refund_admin_notes',
        'refund_processed_at',
    ];

    protected $casts = [
        'refund_requested_at' => 'datetime',
        'refund_processed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /* ---- Status helpers ---- */

    public function isRefundRequested(): bool
    {
        return $this->booking_status === 'refund_requested';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function canRequestRefund(): bool
    {
        return $this->booking_status === 'confirmed'
            && $this->payment_status === 'paid'
            && \Carbon\Carbon::parse($this->flightInstance->flight_date)->endOfDay()->isFuture();
    }

    public function canCancel(): bool
    {
        // Unpaid bookings (pending) can be cancelled directly
        return in_array($this->booking_status, ['pending', 'confirmed'])
            && in_array($this->payment_status, ['unpaid', 'pending']);
    }

    /**
     * Calculate refund amount based on time remaining before flight.
     * > 48h: 90%
     * 24-48h: 50%
     * < 24h: 0%
     */
    public function calculateRefundAmount(): array
    {
        if (!$this->flightInstance || !$this->flightInstance->schedule) {
            return [
                'percentage' => 0,
                'amount' => 0,
                'penalty' => $this->total_price_usd,
                'policy' => 'Flight data missing',
                'hours_remaining' => 0
            ];
        }

        // Use the flight date and schedule's departure time
        $flightDateStr = \Carbon\Carbon::parse($this->flightInstance->flight_date)->format('Y-m-d');
        $departureTimeStr = $this->flightInstance->schedule->departure_time_gmt;
        
        $departureTimestamp = \Carbon\Carbon::parse($flightDateStr . ' ' . $departureTimeStr);
        $now = \Carbon\Carbon::now();
        
        // Calculate the difference in hours (positive means departure is in the future)
        $hoursDiff = $now->diffInHours($departureTimestamp, false);
        
        $percentage = 0;
        $policy = '< 24 Jam (0% Refund / Hangus)';

        if ($hoursDiff > 48) {
            $percentage = 90;
            $policy = '> 48 Jam (90% Refund)';
        } elseif ($hoursDiff >= 24) {
            $percentage = 50;
            $policy = '24 - 48 Jam (50% Refund)';
        }

        $refundAmount = $this->total_price_usd * ($percentage / 100);
        $penalty = $this->total_price_usd - $refundAmount;

        return [
            'percentage' => $percentage,
            'amount' => $refundAmount,
            'penalty' => $penalty,
            'policy' => $policy,
            'hours_remaining' => ceil($hoursDiff)
        ];
    }

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

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'booking_id');
    }
}