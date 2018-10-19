<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LateNotification
 * @package App\Models
 *
 * @property int $id
 * @property int $booking_id
 * @property int $delay_minutes
 * @property string $photo_s3_url
 * @property string $reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Booking $booking
 */
class LateNotification extends Model
{
    protected $table = 'late_notifications';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'delay_minutes',
        'photo_s3_link',
        'reason',
    ];

    protected $visible = [
        'id',
        'booking_id',
        'delay_minutes',
        'photo_s3_link',
        'reason',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
