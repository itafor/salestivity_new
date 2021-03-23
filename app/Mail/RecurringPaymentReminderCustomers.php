<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecurringPaymentReminderCustomers extends Mailable
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
        return $this->markdown('emails.RecurringPaymentReminderCustomers')->with([
            'renewal' => $this->renewal,
            'remaingDays' => $this->remaingDays,
        ])->from('noreply@salestivity.com', 'Salestivity')
        ->subject('Invoice Renewal Notification')
        ->cc('billing@digitalwebglobal.com','digitalwebglobal');
    }
}
