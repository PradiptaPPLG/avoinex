<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $primaryKey = 'airport_id';
    protected $fillable = ['iata_code', 'airport_name', 'city', 'country_code'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'country_code');
    }

    public function departureSchedules()
    {
        return $this->hasMany(Schedule::class, 'origin_iata_code', 'iata_code');
    }

    public function arrivalSchedules()
    {
        return $this->hasMany(Schedule::class, 'destination_iata_code', 'iata_code');
    }
}