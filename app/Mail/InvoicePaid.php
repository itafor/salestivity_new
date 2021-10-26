<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class InvoicePaid extends Mailable
{
    use Queueable, SerializesModels;

    public $paid_invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paidInvoice)
    {
        $this->paid_invoice = $paidInvoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = view('whatsapp.invoicePaid', [
            'paid_invoice'=> $this->paid_invoice,
        ]);
         
        whatsappNotification('14157386170', '2347065907948', strip_tags($text));

         $pdf = PDF::loadView('emails.invoicePaid', [
            'paid_invoice' => isset($this->paid_invoice) ? $this->paid_invoice : null
            ]);

        $documentName = 'paymentConfirmation_'.$this->paid_invoice->id.'.pdf';

        return $this->view('emails.invoicePaid')
         ->from('notifications@salestivtity.com', getMailFromName($this->paid_invoice->invoice))
         ->replyTo(getReplyToEmailAddress($this->paid_invoice->invoice))
        ->subject('Confirmation of Payment')
        ->attachData($pdf->output(), $documentName)
        ->cc(getUserCCEmailAddress($this->paid_invoice->invoice));
    }
}
