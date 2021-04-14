<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Jobs\NotifyDueRenewalJob;
use App\Mail\EmailInvoiceRenewalToCustomer;
use App\Mail\EmailInvoiceRenewalToOtherContacts;
use App\Renewal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CronJobController extends Controller
{
  
    public static function annualRenewalsNotification()
    {
       
      $renewals = Renewal::where([
        ['billingBalance','>',0],
        ['end_date', '>=', Carbon::now()]
      ])
      ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,renewals.start_date,renewals.end_date) AS days'),
     DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
     ->get();
   //dd($renewals);
       foreach($renewals as $renewal) {
        $duration = $renewal->duration;
      
           if($duration && $duration->first_duration == $renewal->remaingdays){
               $renewalContacts = $renewal->contacts;
                     self::notifyCustomer($renewal);
               if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          }elseif ($duration && $duration->second_duration == $renewal->remaingdays) {
            $renewalContacts = $renewal->contacts;
                    self::notifyCustomer($renewal);
                     if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          }elseif ($duration && $duration->third_duration == $renewal->remaingdays) {
           $renewalContacts = $renewal->contacts;
                     self::notifyCustomer($renewal);
                      if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          }
        }

 }

     public static function firstRecurringReminderMail()
    {
       
      $renewals = Renewal::where([
        ['billingBalance','>',0],
        ['first_reminder_sent','no'],
        ['end_date', '>=', Carbon::now()]
      ])
      ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,renewals.start_date,renewals.end_date) AS days'),
     DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
     ->get();
 
 //dd($renewals);

       foreach($renewals as $renewal) {
            if($renewal->days == 365){
                    $renewalContacts = $renewal->contacts;
                     self::notifyCustomer($renewal);
               if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          self::updateRenewal($renewal->id);
      }
           
    }
 }


    public static function dueUnpaidRenewalsMonthlyNotification()
    {
       
      $renewals = Renewal::where([
        ['billingBalance', '>', 0],
        ['end_date', '<=', Carbon::now()],
      ])
      ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,renewals.start_date,renewals.end_date) AS days'),
     DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
     ->get();
 //dd($renewals);

       foreach($renewals as $renewal) {
            if($renewal->remaingdays <= 0){
                    $renewalContacts = $renewal->contacts;
                     self::notifyCustomer($renewal);
               if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
      }
           
    }
 }


public static function notifyCustomer($renewal){
  
          $customerEmail = $renewal->customers->email;
          if($customerEmail){
          $remaingDays = (string)$renewal->remaingdays;
            Mail::to($customerEmail)->queue(new EmailInvoiceRenewalToCustomer($renewal,$remaingDays));
          }
}


  public static function sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts) {


  	   foreach ($renewalsWithcontacts as $key => $contact) {

                $customerContact=Contact::where('id',$contact->contact_id)->first();
		            $renewal=Renewal::where('id',$contact->renewal_id)
                 ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
                 ->first();
                 $remaing_days = $renewal->remaingdays;

            $toEmail = $customerContact->email;

   Mail::to($toEmail)->queue(new EmailInvoiceRenewalToOtherContacts($renewal,$customerContact,$remaing_days));

		    }
  }




    public static function updateRenewal($renewal_id)
    {
        Renewal::where('id', $renewal_id)->update([
        'first_reminder_sent' => 'yes',
        ]); 
    }

}
