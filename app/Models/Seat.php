<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'seat_id';
    protected $table = 'seats';

    protected $fillable = ['aircraft_id', 'seat_number', 'seat_class'];
}