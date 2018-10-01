<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TLCLicense
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $front
 * @property string $back
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereFront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TLCLicense whereUserId($value)
 */
class TLCLicense extends Model
{
    //
}
