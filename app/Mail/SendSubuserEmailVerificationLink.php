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
    public $user_type;
    public $verification_link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userType, $verification_link)
    {
        $this->subUser = $user;
        $this->user_type = $userType;
        $this->verification_link = $verification_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subuserEmailVerificationlink')
        ->from('notifications@salestivtity.com', 'Salestivity')
        ->subject('Verify your email');
    }
}
