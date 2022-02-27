<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MainUserEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

     public $user;
    public $user_type;
    public $verification_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userType, $verification_link)
    {
         $this->user = $user;
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
        return $this->view('emails.mainEmailVerificationlink')
        ->from('notifications@salestivtity.com', 'Salestivity')
        ->subject('Verify your email');
    }
}
