<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubuserEmailVerificationLink extends Mailable
{
    use Queueable, SerializesModels;

    public $subUser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->subUser = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subuserEmailVerificationlink')
        ->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Verify your email');
    }
}
