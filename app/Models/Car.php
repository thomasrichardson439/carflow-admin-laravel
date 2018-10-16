<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App\Models
 *
 * @property int $id
 * @property string $image_s3_url
 * @property string $manufacturer
 * @property string $model
 * @property string $color
 * @property int $year
 * @property string $plate
 * @property string $full_pickup_location
 * @property string $full_return_location
 * @property string $short_pickup_location
 * @property string $short_return_location
 * @property float $pickup_location_lat
 * @property float $pickup_location_lon
 * @property float $return_location_lat
 * @property float $return_location_lon
 * @property string $booking_available_from
 * @property string $booking_available_to
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Carbon $booking_available_from_carbon
 * @property Carbon $booking_available_to_carbon
 */
class Car extends Model
{
    protected $table = 'cars';

    protected $dates = [
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
        'full_pickup_location',
        'full_return_location',
        'short_pickup_location',
        'short_return_location',
        'pickup_location_lat',
        'pickup_location_lon',
        'return_location_lat',
        'return_location_lon',
        'booking_available_from',
        'booking_available_to',
    ];

    protected $visible = [
        'id',
        'image_s3_url',
        'manufacturer',
        'model',
        'color',
        'year',
        'plate',
        'full_pickup_location',
        'full_return_location',
        'short_pickup_location',
        'short_return_location',
        'pickup_location_lat',
        'pickup_location_lon',
        'return_location_lat',
        'return_location_lon',
        'booking_available_from',
        'booking_available_to',
    ];

    protected $casts = [
        'pickup_location_lat' => 'float',
        'pickup_location_lon' => 'float',
        'return_location_lat' => 'float',
        'return_location_lon' => 'float',
    ];

    /**
     * @return Carbon
     */
    public function getBookingAvailableFromCarbonAttribute() : Carbon
    {
        return Carbon::parse($this->booking_available_from);
    }

    /**
     * @return Carbon
     */
    public function getBookingAvailableToCarbonAttribute() : Carbon
    {
        return Carbon::parse($this->booking_available_to);
    }
}
