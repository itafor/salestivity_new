<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyDueRenewalToCustomer extends Mailable
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
        return $this->view('emails.notify_due_renewal_tocustomer')
         ->from('noreply@salestivity.com')
        ->subject('Due Renewal Notification')
        ->cc('billing@digitalwebglobal.com','digitalwebglobal');
    }
}
