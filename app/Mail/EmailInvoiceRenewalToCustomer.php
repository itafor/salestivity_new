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

         return $this->view('emails.email_invoice_renewal_to_customer')
         ->from($this->renewal->compEmail ?  $this->renewal->compEmail->email : $this->renewal->user->email)
        ->subject('Invoice Renewal Notification')
        ->attachData($pdf->output(), "invoiceRenewal.pdf");
        // ->cc('billing@digitalwebglobal.com','digitalwebglobal');
    }
}
