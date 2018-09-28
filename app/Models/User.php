<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \App\Models\DrivingLicense $drivingLicense
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Models\TLCLicense $tlcLicense
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @mixin \Eloquent
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
        'full_name', 'email', 'password', 'address',
        'phone', 'step', 'status', 'uber_approved', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['tlcLicense', 'drivingLicense'];

    public function drivingLicense()
    {
        return $this->hasOne(DrivingLicense::class);
    }

    public function tlcLicense()
    {
        return $this->hasOne(TLCLicense::class);
    }

    // public function getDrivingLicenseAttribute()
    // {
    //     return $this->drivingLicense();
    // }
    //
    // public function getTlcLicenseAttribute()
    // {
    //     return $this->drivingLicense();
    // }
}
