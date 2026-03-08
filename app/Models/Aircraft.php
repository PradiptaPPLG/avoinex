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
        'template_id',
        'seat_columns',
        'seat_rows',
        'business_rows',
        'preferred_zone_enabled',
        'preferred_zone_start_row',
        'preferred_zone_end_row',
        'is_active',
    ];

    protected $casts = [
        'preferred_zone_enabled' => 'boolean',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(AircraftManufacturer::class , 'manufacturer_id', 'aircraft_manufacturer_id');
    }

    // TEMPORARY FIX: SIMPLE VERSION
    public function template()
    {
        // Skip relationship for now
        return null;
    }

    public function seats()
    {
        return $this->hasMany(Seat::class , 'aircraft_id', 'aircraft_id');
    }

    public function aircraftInstances()
    {
        return $this->hasMany(AircraftInstance::class , 'aircraft_id', 'aircraft_id');
    }

    /**
     * Get seat column letters based on seat_columns count.
     * e.g. 6 => ['A','B','C','D','E','F']
     */
    public function getSeatLettersAttribute()
    {
        $cols = $this->seat_columns ?? 6;
        $letters = [];
        for ($i = 0; $i < $cols; $i++) {
            $letters[] = chr(65 + $i); // A=65
        }
        return $letters;
    }

    /**
     * Get the row where economy class starts.
     */
    public function getEconomyStartRowAttribute()
    {
        $afterBusiness = ($this->business_rows ?? 2) + 1;
        if ($this->preferred_zone_enabled && $this->preferred_zone_end_row) {
            return $this->preferred_zone_end_row + 1;
        }
        return $afterBusiness;
    }
}