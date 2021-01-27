<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Jobs\NotifyDueRenewalJob;
use App\Mail\NotifyDueRenewalToCustomer;
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
// dd($renewals);

       foreach($renewals as $renewal) {
           if($renewal->remaingdays == 339){
               $renewalContacts = $renewal->contacts;
                     self::notifyCustomer($renewal);
               if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          }elseif ($renewal->remaingdays == 3) {
            $renewalContacts = $renewal->contacts;
                    self::notifyCustomer($renewal);
                     if($renewalContacts){
           self::sendNotificationToContactsAttachedToRenewal($renewalContacts);
          }
          }elseif ($renewal->remaingdays == 5) {
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
            Mail::to($customerEmail)->send(new NotifyDueRenewalToCustomer($renewal,$remaingDays));
          }
}


  public static function sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts) {


  	   foreach ($renewalsWithcontacts as $key => $contact) {

                $customerContact=Contact::where('id',$contact->contact_id)->first();
		            $renewal=Renewal::where('id',$contact->renewal_id)
                 ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
                 ->first();
                 $remaing_days = $renewal->remaingdays;

		         NotifyDueRenewalJob::dispatch($renewal,$customerContact,$remaing_days)
		    ->delay(now()->addSeconds(5));

		    }
  }




//   public static function getRenewals($percentage) {
//   $renewals = Renewal::where('billingBalance','>',0)
//      ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),renewals.end_date ) =  ROUND(ABS(TIMESTAMPDIFF(DAY, renewals.start_date,renewals.end_date ) * ('.$percentage.'/100) ),0)')->with(['contacts','customers'])
//          ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
//          ->get();
//        return $renewals;
// }

}
