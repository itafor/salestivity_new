<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

/**
 * [Description SendRenewalPaymentNotice]
 */
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
        $pdf = PDF::loadView(
            'emails.send_renewal_payment_notice',
            [
            'renewal' => $this->renewal,
            'payment_status' => $this->payment_status,
            ]
        );

        $documentName = 'paymentConfirmation_'.'.pdf';

        return $this->view('emails.send_renewal_payment_notice')
        ->attachData($pdf->output(), $documentName)
        ->subject('Confirmation of Payment');
    }
}
