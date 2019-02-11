<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeviceToken
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $device_token
 * @property Carbon $updated_at
 * @property Carbon $created_at
 */
class DeviceToken extends Model
{
    protected $table = 'device_tokens';

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [];

    protected $visible = [
        'id',
        'user_id',
        'device_token',
        'created_at',
    ];
}
