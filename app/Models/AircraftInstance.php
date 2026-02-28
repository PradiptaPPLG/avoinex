<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftInstance extends Model
{
    use HasFactory;

    protected $primaryKey = 'aircraft_instance_id';
    protected $table = 'aircraft_instances';

    protected $fillable = ['registration_number', 'aircraft_id'];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id', 'aircraft_id');
    }

    public function flightInstances()
    {
        return $this->hasMany(FlightInstance::class, 'aircraft_instance_id', 'aircraft_instance_id');
    }
}