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

    $text = view('whatsapp.renewalPaid', [
            'renewal'=> $this->renewal, 
            'payment_status'=> $this->payment_status, 
        ]);
    
         whatsappNotification('14157386170', '2347065907948', strip_tags($text));

        return $this->view('emails.renewalPaid')
         ->replyTo('billing@digitalweb247.com','Digitalweb247')
        ->subject('Renewal Payment Notification')
        ->cc('billing@digitalweb247.com','Digitalweb247');
    }
}
