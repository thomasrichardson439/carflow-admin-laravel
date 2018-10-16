<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DrivingLicense
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $front
 * @property string $back
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereFront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DrivingLicense whereUserId($value)
 */
class DrivingLicense extends Model
{
    protected $table = 'driving_licenses';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $visible = [
        'id',
        'front',
        'back',
        'created_at',
    ];
}
