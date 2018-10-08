<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserReviewNotification extends Mailable
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
        return $this->from('admin@carflow.com', 'CarFlow')
            ->subject('CarFlow')
            ->markdown(
                'emails.user_review',
                ['newUserStatus' => $this->newUserStatus]
            );
    }
}
