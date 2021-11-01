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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userType)
    {
         $this->user = $user;
         $this->user_type = $userType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mainEmailVerificationlink')
        ->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Verify your email');
    }
}
