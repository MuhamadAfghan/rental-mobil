<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'so_number',
        'car_id',
        'pickup_date',
        'return_date',
        'pickup_time',
        'return_time',
        'pickup_location',
        'is_confirmed',
        'total_price',
        'status',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
