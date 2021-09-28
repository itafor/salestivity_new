<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class EmailInvoiceRenewalToOtherContacts extends Mailable
{
    use Queueable, SerializesModels;

    public $customerRenewal;
    public $customerContact;
    public $remaing_days;
    /**
     * Create a new message instance.
        // ->attachData(base64_decode($this->pdf)->output(), "invoiceRenewal.pdf")
     * 
     * @return void
     */
      public function __construct($renewal,$customerContact,$remaing_days)
    {
        $this->customerRenewal = $renewal;
        $this->customerContact = $customerContact;
       $this->remaing_days = $remaing_days;
        // dd($this->remaing_days);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.email_invoice_renewal_to_other_contacts', [
            'customerRenewal'=> $this->customerRenewal, 
            'customerContact' => $this->customerContact, 
            'remaing_days' => $this->remaing_days
        ]);

        $documentName = 'invoiceRenewal_'.$this->customerRenewal->invoice_number.'.pdf';

        return $this->view('emails.email_invoice_renewal_to_other_contacts')
         ->from('notifications@salestivtity.com', getMailFromName($this->customerRenewal))
        ->replyTo(getReplyToEmailAddress($this->customerRenewal))
        ->attachData($pdf->output(), $documentName)
        ->subject('Managed Hosting Invoice');
    }
}
