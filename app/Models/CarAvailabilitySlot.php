<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarAvailabilitySlot extends Model
{
    const TYPE_RECURRING = 'recurring';
    const TYPE_ONE_TIME = 'one-time';

    protected $table = 'car_availability_slots';

    protected $fillable = [
        'car_id',
        'availability_type',
        'available_at',
        'available_at_recurring',
        'available_hour_from',
        'available_hour_to',
    ];

    public $timestamps = false;

    protected $dates = [
        'available_at',
    ];

    protected $visible = [
        'availability_type',
        'available_at',
        'available_at_recurring',
        'available_hour_from',
        'available_hour_to',
    ];
}
