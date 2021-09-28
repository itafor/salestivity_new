<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.sendinvoice', [
            'invoice'=> $this->invoice,
        ]);

        $documentName = 'invoicePayment_'.$this->invoice->invoice_number.'.pdf';

        
        $text = view('whatsapp.sendinvoice', [
            'invoice'=> $this->invoice,
        ]);

        whatsappNotification('14157386170', '2347065907948', strip_tags($text));
    
        return $this->view('emails.sendinvoice')
        ->from('notifications@salestivtity.com', getMailFromName($this->invoice))
        ->replyTo(getReplyToEmailAddress($this->invoice))
        ->attachData($pdf->output(), $documentName)
        ->subject('Invoice Notification')
        ->cc(getUserCCEmailAddress($this->invoice));
        
    }
}
