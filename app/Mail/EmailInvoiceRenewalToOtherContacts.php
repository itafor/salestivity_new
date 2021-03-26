<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailInvoiceRenewalToOtherContacts extends Mailable
{
    use Queueable, SerializesModels;

    public $customerRenewal;
    public $customerContact;
    public $remaing_days;
    /**
     * Create a new message instance.
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
        return $this->view('emails.email_invoice_renewal_to_other_contacts')
        ->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Invoice Renewal Notification');
    }
}
