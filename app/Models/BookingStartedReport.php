<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingStartedReport
 * @package App\Models
 *
 * @property int $id
 * @property int $booking_id
 * @property string $photo_front_s3_link
 * @property string $photo_back_s3_link
 * @property string $photo_left_s3_link
 * @property string $photo_right_s3_link
 * @property string $photo_gas_tank_s3_link
 * @property string $photo_mileage_s3_link
 */

class BookingStartedReport extends Model
{
    protected $table = 'booking_started_reports';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'photo_front_s3_link',
        'photo_back_s3_link',
        'photo_left_s3_link',
        'photo_right_s3_link',
        'photo_gas_tank_s3_link',
        'photo_mileage_s3_link',
    ];

    protected $visible = [
        'id',
        'photo_front_s3_link',
        'photo_back_s3_link',
        'photo_left_s3_link',
        'photo_right_s3_link',
        'photo_gas_tank_s3_link',
        'photo_mileage_s3_link',
        'created_at',
    ];
}