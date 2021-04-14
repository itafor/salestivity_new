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

        return $this->view('emails.sendinvoice')
        ->from($this->invoice->compEmail ? $this->invoice->compEmail->email : $this->invoice->user->email)
        ->attachData($pdf->output(), "invoicePayment.pdf")
        ->subject('Invoice Payment Notification');
    }
}
