<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRenewalPaymentNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $customerContacts;
    public $renewal;
    public $payment_status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($renewal,$customerContacts,$payment_status)
    {
        $this->renewal = $renewal;
        $this->customerContacts = $customerContacts;
        $this->payment_status = $payment_status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send_renewal_payment_notice')
         ->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Renewal Payment Notification');
    }
}
