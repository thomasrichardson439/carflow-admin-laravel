<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Booking
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon $booking_starting_at - should always be h:00:00
 * @property Carbon $booking_ending_at - should always be h:59:59, in order to avoid interferration of dates
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Car $car
 * @property User $user
 */
class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'car_id',
        'booking_starting_at',
        'booking_ending_at',
    ];

    protected $dates = [
        'booking_starting_at',
        'booking_ending_at',
        'created_at',
        'updated_at',
    ];

    protected $visible = [
        'id',
        'car_id',
        'booking_starting_at',
        'booking_ending_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function car()
    {
        return $this->hasOne(Car::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
