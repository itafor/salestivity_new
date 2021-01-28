<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        return $this->view('emails.invoicePaid')
        ->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Invoice Payment Notification');
    }
}
