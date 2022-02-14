<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.custom_reset_password_email')
        ->from('noreply@salestivtity.com', 'Salestivity')
        ->with([
            'link' => $this->link
        ])
        ->subject('Reset Password Notification');
    }
}
