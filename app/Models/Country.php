<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $primaryKey = 'country_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'country_code',
        'country_name',
        'phone_code',
        'continent'
    ];

    // Relationships
    public function airports()
    {
        return $this->hasMany(Airport::class, 'country_code', 'country_code');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'iata_country_code', 'country_code');
    }

    public function airlines()
    {
        return $this->hasMany(Airline::class, 'country_code', 'country_code');
    }
}