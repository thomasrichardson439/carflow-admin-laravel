<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Document
 *
 * @mixin \Eloquent
 */
class Document extends Model
{
    protected $fillable = ['path'];
}
