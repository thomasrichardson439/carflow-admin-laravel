<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CarCategory
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CarCategory extends Model
{
    protected $table = 'car_categories';

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
