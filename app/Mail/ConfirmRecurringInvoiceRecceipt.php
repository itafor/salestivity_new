<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmRecurringInvoiceRecceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $renewal;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($renewal)
    {
        $this->renewal = $renewal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.confirm_recurring_invoice_recceipt')
        ->subject('Recurring Invoice Receipt Confirmation');

    }
}
