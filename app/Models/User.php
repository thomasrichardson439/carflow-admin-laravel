<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property Booking[] $bookings
 * @property Booking[] $endedBookings
 * @property Booking[] $canceledBookings
 * @property Booking|null $lastBooking
 * @property BookingReceipt[] $receipts
 * @property BookingIssueReport[] $accidents
 * @property BookingIssueReport[] $malfunctions
 * @property string[] $ridesharing_apps_list
 * @property BookingIssueReport[] $issueReports
 *
 * @mixin \Eloquent
 *
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
 * @property string $policy_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
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
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_PENDING_PROFILE = 'pending_profile';
    public const STATUS_REJECTED_PROFILE = 'rejected_profile';

    use HasApiTokens, Notifiable, SoftDeletes;

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
        'photo',
        'policy_number',
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
    protected $with = [
        'tlcLicense',
        'drivingLicense',
        'profileUpdateRequest',
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function canceledBookings()
    {
        return $this->hasMany(Booking::class)->where('status', Booking::STATUS_CANCELED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', Booking::STATUS_ENDED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastBooking()
    {
        return $this->hasOne(Booking::class)->orderBy('created_at', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function receipts()
    {
        return $this->hasManyThrough(
            BookingReceipt::class,
            Booking::class
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function accidents()
    {
        return $this->hasManyThrough(
            BookingIssueReport::class,
            Booking::class
        )->where('report_type', BookingIssueReport::TYPE_DAMAGE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function malfunctions()
    {
        return $this->hasManyThrough(
            BookingIssueReport::class,
            Booking::class
        )->where('report_type', BookingIssueReport::TYPE_MALFUNCTION);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function issueReports()
    {
        return $this->hasManyThrough(
            BookingIssueReport::class,
            Booking::class
        );
    }

    /**
     * Accessors for ridesharing apps list
     * @return array
     */
    public function getRideSharingAppsListAttribute()
    {
        return array_filter(
            array_map('trim',
                explode(',', $this->ridesharing_apps)
            )
        );
    }
}
