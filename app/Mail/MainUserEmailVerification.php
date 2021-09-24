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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
         $this->user = $user;
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
