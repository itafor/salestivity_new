<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecurringPaymentReminderUser extends Mailable
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

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.RecurringPaymentReminderUser')->with([
            'customerRenewal' => $this->customerRenewal,
            'customerContact' => $this->customerContact,
            'remaing_days' => $this->remaing_days,
        ])->from('noreply@salestivity.com', 'Salestivity')->subject('Invoice Renewal Notification');
    }
}
