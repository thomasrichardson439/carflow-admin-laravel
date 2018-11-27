<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserProfileReviewNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $newUpdateStatus;

    /**
     * @var string
     */
    private $rejectReason;

    /**
     * Create a new message instance.
     * @param string $newUpdateStatus
     * @param string $rejectReason
     */
    public function __construct(User $user, string $newUpdateStatus, string $rejectReason = '')
    {
        $this->user = $user;
        $this->newUpdateStatus = $newUpdateStatus;
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
            ->subject('Car Flo - Profile update status')
            ->view(
                'emails.user_profile_review',
                [
                    'user' => $this->user,
                    'newUpdateStatus' => $this->newUpdateStatus,
                    'rejectReason' => $this->rejectReason,
                ]
            );
    }
}
