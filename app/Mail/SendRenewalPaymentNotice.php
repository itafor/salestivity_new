<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRenewalPaymentNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $renewal;
    public $payment_status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($renewal, $payment_status)
    {
        $this->renewal = $renewal;
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
        ->subject('Renewal Payment Notification');
    }
}
