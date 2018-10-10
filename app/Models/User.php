<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property \App\Models\DrivingLicense $drivingLicense
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property \App\Models\TLCLicense $tlcLicense
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property UserProfileUpdate $profileUpdateRequest
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $full_name
 * @property string $email
 * @property string $password
 * @property int $admin
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $photo
 * @property string|null $ridesharing_apps
 * @property string $status
 * @property int $documents_uploaded
 * @property int $ridesharing_approved
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDocumentsUploaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRidesharingApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRidesharingApps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'address',
        'phone',
        'step',
        'status',
        'uber_approved',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'full_name',
        'email',
        'address',
        'phone',
        'photo',
        'ridesharing_apps',
        'status',
        'documents_uploaded',
        'ridesharing_approved',
        'created_at',

        'drivingLicense',
        'tlcLicense',
        'profileUpdateRequest',
    ];

    /**
     * @var array
     */
    protected $relations = [
        'drivingLicense',
        'tlcLicense'
    ];

    /**
     * @var array
     */
    protected $with = ['tlcLicense', 'drivingLicense'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function drivingLicense()
    {
        return $this->hasOne(DrivingLicense::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tlcLicense()
    {
        return $this->hasOne(TLCLicense::class);
    }

    /**
     * Allows to get the latest profile update request (if any)
     */
    public function profileUpdateRequest()
    {
        return $this->hasOne(UserProfileUpdate::class)
            ->orderBy('created_at', 'DESC')
            ->limit(1);
    }
}
