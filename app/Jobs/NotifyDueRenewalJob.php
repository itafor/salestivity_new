<?php

namespace App\Jobs;

use App\Mail\NotifyDueRenewalEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyDueRenewalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $customerRenewal;
    public $customerContact;
    public $remaing_days;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customerRenewal,$customerContact,$remaing_days)
    {
        $this->customerRenewal = $customerRenewal;
        $this->customerContact = $customerContact;
        $this->remaing_days = $remaing_days;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $toEmail = $this->customerContact->email;

   Mail::to($toEmail)->send(new NotifyDueRenewalEmail($this->customerRenewal,$this->customerContact,$this->remaing_days));
    }
    
}
