<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $newUserStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(string $newUserStatus)
    {
        $this->newUserStatus = $newUserStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('CarFlow - Account registration status')
            ->markdown(
                'emails.user_review',
                ['newUserStatus' => $this->newUserStatus]
            );
    }
}
