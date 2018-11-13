<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarAvailabilitySlot extends Model
{
    const TYPE_RECURRING = 'recurring';
    const TYPE_ONE_TIME = 'one-time';

    protected $table = 'car_availability_slots';

    protected $fillable = [];

    public $timestamps = false;

    protected $visible = [
        'availability_type',
        'available_at',
        'available_at_recurring',
        'available_hour_from',
        'available_hour_to',
    ];
}
