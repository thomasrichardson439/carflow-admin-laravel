<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingReceipt
 * @package App\Models
 * @property int $booking_id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property Carbon $receipt_date
 * @property string $photo_s3_link
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BookingReceipt extends Model
{
    protected $table = 'booking_receipts';

    protected $dates = [
        'receipt_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'receipt_date',
        'photo_s3_link',
    ];

    protected $visible = [
        'id',
        'title',
        'description',
        'price',
        'receipt_date',
        'photo_s3_link',
        'created_at',
    ];
}
