<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'payment_code',
        'payment_method',
        'amount_usd',
        'currency',
        'payment_status',
        'gateway_name',
        'gateway_response',
        'paid_at',
        'expiry_at'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}