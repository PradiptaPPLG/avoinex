<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'flight_status_id';
    protected $table = 'flight_statuses';

    protected $fillable = ['name', 'description'];

    public function flightInstances()
    {
        return $this->hasMany(FlightInstance::class, 'flight_status_id', 'flight_status_id');
    }
}