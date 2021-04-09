<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewalPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $renewal;
    public $payment_status;
    //public $billingAgent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($renewal,$payment_status)
    {
        $this->renewal = $renewal;
        $this->payment_status = $payment_status;
        //$this->billingAgent = $billingAgent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.renewalPaid')
        ->from($this->renewal->renewal->compEmail ?  $this->renewal->renewal->compEmail->email : $this->renewal->user->email)
        ->subject('Renewal Payment Notification');
    }
}
