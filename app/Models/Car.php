<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'year',
        'color',
        'fuel_type',
        'transmission',
        'seats',
        'baggage',
        'price_per_day',
        'images',
        'driver',
    ];
}