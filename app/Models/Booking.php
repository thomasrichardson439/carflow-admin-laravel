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
 * @property bool $is_recurring
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $status
 * @property string $photo_start_mileage_s3_link
 * @property string $starting_at_weekday
 * @property string $ending_at_weekday
 *
 * @property BookingIssueReport[] $issueReports
 * @property BookingReceipt[] $receipts
 * @property LateNotification[] $lateNotifications
 * @property BookingEndedReport $endedReport
 * @property Car $car
 * @property User $user
 */
class Booking extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_DRIVING = 'driving';
    const STATUS_ENDED = 'ended';
    const STATUS_CANCELED = 'canceled';

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'car_id',
        'is_recurring',
        'booking_starting_at',
        'booking_ending_at',
        'photo_start_mileage_s3_link',
        'starting_at_weekday',
        'ending_at_weekday',
    ];

    protected $dates = [
        'booking_starting_at',
        'booking_ending_at',
        'created_at',
        'updated_at',
    ];

    protected $visible = [
        'id',
        'booking_starting_at',
        'booking_ending_at',
        'is_recurring',
        'status',
        'car',
        'endedReport',
        'issueReports',
        'receipts',
        'lateNotifications',
        'photo_start_mileage_s3_link',
    ];

    protected $with = [
        'car',
        'endedReport',
        'issueReports',
        'receipts',
        'lateNotifications',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issueReports()
    {
        return $this->hasMany(BookingIssueReport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts()
    {
        return $this->hasMany(BookingReceipt::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lateNotifications()
    {
        return $this->hasMany(LateNotification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function endedReport()
    {
        return $this->hasOne(BookingEndedReport::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
