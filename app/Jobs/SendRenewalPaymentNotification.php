<?php

namespace App\Jobs;

use App\Mail\SendRenewalPaymentNotice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRenewalPaymentNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $customerContacts;
    public $renewalPaymentDetails;
    public $payment_status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($renewalPaymentDetails,$customerContacts,$payment_status)
    {
        $this->renewalPaymentDetails = $renewalPaymentDetails;
        $this->customerContacts = $customerContacts;
        $this->payment_status = $payment_status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    $toEmail = $this->customerContacts->email;

    if($toEmail){

          Mail::to($toEmail)->queue(new SendRenewalPaymentNotice($this->renewalPaymentDetails, $this->payment_status));
    }
 
    }
}
