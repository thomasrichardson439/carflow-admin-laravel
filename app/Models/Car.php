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
 * @property int $manufacturer_id
 * @property int $category_id
 * @property string $model
 * @property string $color
 * @property int $year
 * @property string $plate
 * @property string $full_pickup_location
 * @property string $full_return_location
 * @property int $pickup_borough_id
 * @property int $return_borough_id
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
 *
 * @property CarManufacturer $manufacturer
 * @property CarCategory $category
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
        'manufacturer_id',
        'category_id',
        'model',
        'color',
        'year',
        'plate',
        'full_pickup_location',
        'full_return_location',
        'pickup_borough_id',
        'return_borough_id',
        'pickup_location_lat',
        'pickup_location_lon',
        'return_location_lat',
        'return_location_lon',
        'booking_available_from',
        'booking_available_to',
        'allowed_recurring',
    ];

    protected $visible = [
        'id',
        'image_s3_url',
        'manufacturer',
        'category',
        'model',
        'color',
        'year',
        'plate',
        'full_pickup_location',
        'full_return_location',
        'pickup_location_lat',
        'pickup_location_lon',
        'return_location_lat',
        'return_location_lon',
        'booking_available_from',
        'booking_available_to',
        'pickupBorough',
        'returnBorough',
        'allowed_recurring',
    ];

    protected $casts = [
        'pickup_location_lat' => 'float',
        'pickup_location_lon' => 'float',
        'return_location_lat' => 'float',
        'return_location_lon' => 'float',
    ];

    protected $with = [
        'pickupBorough',
        'returnBorough',
        'manufacturer',
        'category',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manufacturer()
    {
        return $this->belongsTo(CarManufacturer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CarCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pickupBorough()
    {
        return $this->belongsTo(Borough::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function returnBorough()
    {
        return $this->belongsTo(Borough::class);
    }
}
