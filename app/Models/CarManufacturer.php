<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarManufacturer
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CarManufacturer extends Model
{
    protected $table = 'car_manufacturers';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [];

    protected $visible = [
        'id',
        'name',
        'created_at',
    ];
}
