<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

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
    public function __construct($renewal, $payment_status)
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
       
        $pdf = PDF::loadView('emails.renewalPaid',[
            'renewal'=> $this->renewal,
            'payment_status' => $this->payment_status
            ]);

        $documentName = 'paymentConfirmation_'.$this->renewal->id.'.pdf';

        return $this->view('emails.renewalPaid')
            ->from('notifications@salestivtity.com', getMailFromName($this->renewal->renewal))
            ->replyTo(getReplyToEmailAddress($this->renewal->renewal))
            ->subject('Confirmation of Payment')
            ->attachData($pdf->output(), $documentName)
           ->cc(getUserCCEmailAddress($this->renewal->renewal));

    }
}
