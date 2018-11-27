<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 11/22/18
 * Time: 7:09 PM
 */

namespace App\Mail;


use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPolicyNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $policyNumber;

    private $user;

    public function __construct(string $policyNumber, User $user)
    {
        $this->policyNumber = $policyNumber;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = $this->from(config('mail.appOwner.address'), config('mail.appOwner.name'))
            ->subject('Car Flo - ' . $this->user->full_name . ' ' . $this->policyNumber)
            ->view(
                'emails.policy_number',
                ['user' => $this->user, 'policyNumber' => $this->policyNumber]
            );

        if (!empty($this->user->drivingLicense)) {
            $settings->attach($this->user->drivingLicense->front)
                ->attach($this->user->drivingLicense->back);
        }


        if (!empty($this->user->tlcLicense)) {
            $settings->attach($this->user->tlcLicense->front)
                ->attach($this->user->tlcLicense->back);
        }

        return $settings;
    }
}