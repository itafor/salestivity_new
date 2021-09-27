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

     $text = view('whatsapp.email_invoice_renewal_to_customer', [
            'renewal'=> $this->renewal, 
            'remaingDays' => $this->remaingDays, 
        ]);

         whatsappNotification('14157386170', '2347065907948', strip_tags($text));

        $documentName = 'invoiceRenewal_'.$this->renewal->invoice_number.'.pdf';

         return $this->view('emails.email_invoice_renewal_to_customer')
        ->from('noreply@salestivity.com', getMailFromName($this->renewal))
        ->replyTo(getReplyToEmailAddress($this->renewal))
        ->subject('Managed Hosting Invoice')
        ->attachData($pdf->output(), $documentName)
        ->cc('billing@digitalweb247.com','Digitalweb247');
    }
}
