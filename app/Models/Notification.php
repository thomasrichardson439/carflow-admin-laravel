<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * @package App\Models
 *
 * @property int $id
 * @property int $device_token_id
 * @property int $type
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

    protected $table = 'notifications';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [];

    protected $visible = [
        'id',
        'device_token_id',
        'type',
        'created_at',
    ];
}
