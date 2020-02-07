<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyDueRenewalEmail extends Mailable
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
    public function __construct($customerRenewal,$customerContact,$remaing_days)
    {
        $this->customerRenewal = $customerRenewal;
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
        return $this->view('emails.notify_due_renewal_email')
        ->from('noreply@salestivity.com')
        ->subject('Due Renewal Notification')
        ->cc('billing@digitalwebglobal.com','digitalwebglobal');
    }
}
