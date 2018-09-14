<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'phone', 'step', 'state', 'status', 'uber_approved', 'photo'
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
