<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owners';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'tlc_photo',
        'fh_photo',
        'status'
    ];
}
