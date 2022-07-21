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

           self::update_renewal_bill_status_to_sent($renewal);

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

  public static function renewExpiredReccuringByOneYear()
    {
       
      $renewals = Renewal::where([
        ['renew_status', null],
        ['end_date', '<=', Carbon::now()],
      ])->get();
   
   dd($renewals);

       foreach($renewals as $renewal) {

        $contactEmails = $renewal->contacts;
        
        $discountValue = $renewal->discount ? $renewal->discount : null;
        $discountedPrice = ($discountValue / 100) * $renewal->productPrice;
        $finalPrice = $renewal->productPrice - $discountedPrice;

         $data['first_duration'] = $renewal->duration ? $renewal->duration->first_duration : 60;
        $data['second_duration'] = $renewal->duration ? $renewal->duration->second_duration : 30;
        $data['third_duration'] = $renewal->duration ? $renewal->duration->third_duration : 7;

        $new_renewal = new Renewal();
        $new_renewal->main_acct_id = $renewal->main_acct_id;
        $new_renewal->created_by_id =  $renewal->created_by_id;
        $new_renewal->customer_id = $renewal->customer_id;
        $new_renewal->category_id = $renewal->category_id;
        $new_renewal->subcategory_id = $renewal->subcategory_id;
        $new_renewal->product_id = $renewal->product_id;
        $new_renewal->productPrice = $renewal->productPrice;
        $new_renewal->discount = $renewal->discount;
        $new_renewal->duration_type = $renewal->duration_type;
        $new_renewal->billingAmount =  $finalPrice;  
        $new_renewal->billingBalance = $finalPrice;
        $new_renewal->userType = $renewal->userType;
        $new_renewal->description = $renewal->description;
        $new_renewal->start_date = Carbon::parse($renewal->end_date);
        $new_renewal->end_date =  Carbon::parse($renewal->end_date)->addYear();
        $new_renewal->first_reminder_sent = 'no';
        $new_renewal->invoice_number = 'DW'.mt_rand(1000, 9999);
        $new_renewal->company_email_id = $renewal->company_email_id;
        $new_renewal->company_bank_acc_id = $renewal->company_bank_acc_id;
        $new_renewal->save();   

        if($new_renewal){
           Renewal::createRenewalContactEmail($new_renewal,$contactEmails);
           Renewal::createRenewalReminderDuration($data, $new_renewal);
           self::modify_renewal_renew_status($renewal);
        }
           
    }
 }

public static function modify_renewal_renew_status($renewal){
    $reccuring = Renewal::find($renewal->id);
    $reccuring->renew_status = 'Renewed';
    $reccuring->save();
}

public static function update_renewal_bill_status_to_sent($renewal){
    $reccuring = Renewal::find($renewal->id);
    $reccuring->bill_status = 'Sent';
    $reccuring->save();
}

public static function update_renewal_bill_status_to_confirmed($renewal){
    $reccuring = Renewal::find($renewal->id);
    $reccuring->bill_status = 'Confirmed';
    $reccuring->save();
}


}
