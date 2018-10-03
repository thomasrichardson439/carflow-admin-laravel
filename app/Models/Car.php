<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    protected $dates = [
        'booking_starting_at',
        'booking_ending_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'image_s3_url',
        'manufacturer',
        'model',
        'color',
        'year',
        'plate',
        'pickup_location',
        'return_location',
        'booking_starting_at',
        'booking_ending_at',
    ];
}
