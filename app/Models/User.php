<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
* @OA\Schema(
*   schema="User",
*   @OA\Property(property="id", format="int64", type="integer"),
*   @OA\Property(property="full_name", format="string", type="string"),
*   @OA\Property(property="email", format="email", type="string"),
*   @OA\Property(property="admin", format="int64", type="boolean"),
*   @OA\Property(property="street", format="string", type="string"),
*   @OA\Property(property="city", format="string", type="string"),
*   @OA\Property(property="zip_code", format="string", type="string"),
*   @OA\Property(property="state", format="state", type="string"),
*   @OA\Property(property="phone", format="phone", type="string"),
*
* )
*/
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'street', 'city', 'zip_code',
        'phone', 'step', 'state', 'status', 'uber_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
