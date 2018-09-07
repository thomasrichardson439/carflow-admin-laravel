<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentsReviewNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($review_result)
    {
        $this->template = $review_result ? 'emails.approve' : 'emails.reject';
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
                    ->markdown($this->template);
    }
}
