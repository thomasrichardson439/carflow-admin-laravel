<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * @package App\Models
 *
 * @property int $id
 * @property string $device_token_ids
 * @property int $type
 * @property int $status
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 */
class Notification extends Model
{
    public const TYPE_BEFORE_24 = 1;
    public const TYPE_BEFORE_4 = 2;
    public const TYPE_BEFORE_1 = 3;
    public const TYPE_MISSED_0_5 = 4;
    public const TYPE_MISSED_1 = 5;
    public const TYPE_MISSED_1_5 = 6;
    public const TYPE_LEFT_2 = 7;
    public const TYPE_LEFT_1 = 8;
    public const TYPE_SHOULD_BE_RETURNED = 9;

    protected $table = 'notifications';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [];

    protected $visible = [
        'id',
        'device_token_ids',
        'type',
        'status',
        'created_at',
    ];
}
