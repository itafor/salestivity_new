<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Jobs\NotifyDueRenewalJob;
use App\Mail\RecurringPaymentReminderCustomers;
use App\Mail\RecurringPaymentReminderUser;
use App\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CronJobController extends Controller
{
  
    public static function annualRenewalsNotification()
    {
       
      $renewals = Renewal::where([
        ['billingBalance','>',0],
        ['duration_type','Annually']
      ])
      ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,renewals.start_date,renewals.end_date) AS days'),
     DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
     ->get();

       foreach($renewals as $renewal) {
        $duration = $renewal->duration;
      //dd($duration);
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
        ['duration_type','Annually']
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
        ['billingBalance','>',0],
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
            Mail::to($customerEmail)->send(new RecurringPaymentReminderCustomers($renewal,$remaingDays));
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

   Mail::to($toEmail)->send(new RecurringPaymentReminderUser($renewal,$customerContact,$remaing_days));

		    }
  }




    public static function updateRenewal($renewal_id)
    {
        Renewal::where('id', $renewal_id)->update([
        'first_reminder_sent' => 'yes',
        ]); 
    }

}
