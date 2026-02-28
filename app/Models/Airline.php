<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $primaryKey = 'airline_id';
    protected $table = 'airlines';

    protected $fillable = ['airline_code', 'airline_name', 'country_code', 'website', 'contact_phone'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'country_code');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'airline_code', 'airline_code');
    }
}