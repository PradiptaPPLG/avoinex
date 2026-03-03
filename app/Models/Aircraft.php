<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    use HasFactory;

    protected $primaryKey = 'aircraft_id';
    protected $table = 'aircrafts';

    protected $fillable = [
        'registration_number',
        'aircraft_model',
        'manufacturer_id',
        'total_seats',
        'economy_seats',
        'business_seats',
        'template_id'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(AircraftManufacturer::class, 'manufacturer_id', 'aircraft_manufacturer_id');
    }

    // TEMPORARY FIX: SIMPLE VERSION
    public function template()
    {
        // Skip relationship for now
        return null;
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'aircraft_id', 'aircraft_id');
    }

    public function aircraftInstances()
    {
        return $this->hasMany(AircraftInstance::class, 'aircraft_id', 'aircraft_id');
    }
}