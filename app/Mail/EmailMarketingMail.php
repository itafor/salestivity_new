<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailMarketingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $data)
    {
        $this->customer = $customer;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_marketing_mail')
        ->subject($this->data['subject']);
    }
}
