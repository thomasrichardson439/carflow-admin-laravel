<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingIssueReport
 * @package App\Models
 *
 * @property int $booking_id
 * @property string $report_type
 * @property string $photo_1_s3_link
 * @property string $photo_2_s3_link
 * @property string $photo_3_s3_link
 * @property string $photo_4_s3_link
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BookingIssueReport extends Model
{
    const TYPE_DAMAGE = 'damage';
    const TYPE_MALFUNCTION = 'malfunction';

    protected $table = 'booking_issue_reports';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'photo_1_s3_link',
        'photo_2_s3_link',
        'photo_3_s3_link',
        'photo_4_s3_link',
        'license_plate',
        'description',
    ];

    protected $visible = [
        'id',
        'report_type',
        'photo_1_s3_link',
        'photo_2_s3_link',
        'photo_3_s3_link',
        'photo_4_s3_link',
        'description',
        'license_plate',
        'created_at',
    ];
}
