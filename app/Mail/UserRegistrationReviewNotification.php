<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $newUserStatus;

    /**
     * @var string
     */
    private $rejectReason;

    /**
     * Create a new message instance.
     * @param string $newUserStatus
     * @param string $rejectReason
     */
    public function __construct(User $user, string $newUserStatus, string $rejectReason = '')
    {
        $this->user = $user;
        $this->newUserStatus = $newUserStatus;
        $this->rejectReason = $rejectReason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('CarFlo - Account registration status')
            ->view(
                'emails.user_review',
                [
                    'user' => $this->user,
                    'newUserStatus' => $this->newUserStatus,
                    'rejectReason' => $this->rejectReason,
                ]
            );
    }
}
