<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserProfileReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $newUpdateStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(string $newUpdateStatus)
    {
        $this->newUpdateStatus = $newUpdateStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('CarFlow - Profile update status')
            ->markdown(
                'emails.user_profile_review',
                ['newUpdateStatus' => $this->newUpdateStatus]
            );
    }
}
