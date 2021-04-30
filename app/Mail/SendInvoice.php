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

        return $this->view('emails.sendinvoice')
        ->from($this->invoice->compEmail ? $this->invoice->compEmail->email : $this->invoice->user->email)
        ->replyTo($this->invoice->compEmail ? $this->invoice->compEmail->email : $this->invoice->user->email)
        ->attachData($pdf->output(), $documentName)
        ->subject('Invoice Payment Notification')
         ->cc($this->invoice->compEmail ? $this->invoice->compEmail->email : $this->invoice->user->email);
    }
}
