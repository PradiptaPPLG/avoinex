<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatTemplate extends Model
{
    use HasFactory;

    protected $primaryKey = 'template_id';
    protected $table = 'seat_templates';

    protected $fillable = [
        'aircraft_model',
        'manufacturer',
        'total_rows',
        'seats_per_row',
        'seat_map'
    ];

    protected $casts = [
        'seat_map' => 'array'
    ];

    public function aircrafts()
    {
        return $this->hasMany(Aircraft::class, 'template_id', 'template_id');
    }
}