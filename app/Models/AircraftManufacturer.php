<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AircraftManufacturer extends Model
{
    use HasFactory;

    protected $primaryKey = 'aircraft_manufacturer_id';
    protected $table = 'aircraft_manufacturers';

    protected $fillable = ['name', 'country_code', 'founded_year'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'country_code');
    }

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class, 'manufacturer_id', 'aircraft_manufacturer_id');
    }
}