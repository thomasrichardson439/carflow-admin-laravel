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
 * @property string $pickup_location
 * @property string $return_location
 * @property string $booking_starting_at
 * @property string $booking_ending_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Carbon $starting_at_carbon
 * @property Carbon $ending_at_carbon
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
        'pickup_location',
        'return_location',
        'booking_starting_at',
        'booking_ending_at',
    ];

    protected $visible = [
        'id',
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

    /**
     * @return Carbon
     */
    public function getStartingAtCarbonAttribute() : Carbon
    {
        return Carbon::parse($this->booking_starting_at);
    }

    /**
     * @return Carbon
     */
    public function getEndingAtCarbonAttribute() : Carbon
    {
        return Carbon::parse($this->booking_ending_at);
    }
}
