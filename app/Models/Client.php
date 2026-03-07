<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'client_id';
    protected $table = 'clients';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'passport',
        'iata_country_code',
        'password_hash',
        'date_of_birth',
        'google_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class , 'iata_country_code', 'country_code');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class , 'client_id', 'client_id');
    }
}