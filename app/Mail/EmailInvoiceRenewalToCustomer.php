<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class EmailInvoiceRenewalToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $renewal;
    public $remaingDays;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($renewal,$remaingDays)
    {
        $this->renewal = $renewal;
        $this->remaingDays = $remaingDays;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $pdf = PDF::loadView('emails.email_invoice_renewal_to_customer', [
            'renewal'=> $this->renewal, 
            'remaingDays' => $this->remaingDays, 
        ]);

        $documentName = 'invoiceRenewal_'.$this->renewal->invoice_number.'.pdf';

         return $this->view('emails.email_invoice_renewal_to_customer')
         ->replyTo('billing@digitalweb247.com','Digitalweb247')
        ->subject('Invoice Renewal Notification')
        ->attachData($pdf->output(), $documentName)
        ->cc('billing@digitalweb247.com','Digitalweb247');
    }
}
