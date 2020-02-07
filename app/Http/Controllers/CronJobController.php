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
    public static function renewalsNotificationAt15Percent($percentage = 15)
    {
       
       $renewals = self::getRenewals($percentage);
      //dd($renewals);
         $renewalsWithcontacts = [];
         $remaingDays = 0;

        foreach($renewals as $renewal) {
        	if($renewal->contacts->isEmpty()){
        	$toEmail = $renewal->customers->email;
        	if($toEmail){
        	$remaingDays = (string)$renewal->remaingdays;
            Mail::to($toEmail)->send(new NotifyDueRenewalToCustomer($renewal,$remaingDays));
        	}
        }else{
        	$renewalsWithcontacts = $renewal->contacts;
          }
       }  

        $customerContact = [];
        $remaing_days = 0;
     if(count($renewalsWithcontacts) >= 1){
     	$getContacts = new CronJobController();
		$getContacts->sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts);
		}
		return 'Done';
  }



    public static function renewalsNotificationAt5Percent($percentage = 5)
    {
       
       $renewals = self::getRenewals($percentage);
       //dd($renewals);
         $renewalsWithcontacts = [];
         $remaingDays = 0;

        foreach($renewals as $renewal) {
        	if($renewal->contacts->isEmpty()){
        	$toEmail = $renewal->customers->email;
        	if($toEmail){
        	$remaingDays = (string)$renewal->remaingdays;
            Mail::to($toEmail)->send(new NotifyDueRenewalToCustomer($renewal,$remaingDays));
        	}
        }else{
        	$renewalsWithcontacts = $renewal->contacts;
          }
       }  

        $customerContact = [];
        $remaing_days = 0;
     if(count($renewalsWithcontacts) >= 1){
     	$getContacts = new CronJobController();
		$getContacts->sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts);
		}
		return 'Done';
  }

    public static function renewalsNotificationAt0Percent($percentage = 0)
    {
       
       $renewals = self::getRenewals($percentage);
	 // dd($renewals);

         $renewalsWithcontacts = [];
         $remaingDays = 0;

        foreach($renewals as $renewal) {
        	if($renewal->contacts->isEmpty()){
        	$toEmail = $renewal->customers->email;
        	if($toEmail){
        	$remaingDays = (string)$renewal->remaingdays;
            Mail::to($toEmail)->send(new NotifyDueRenewalToCustomer($renewal,$remaingDays));
        	}
        }else{
        	$renewalsWithcontacts = $renewal->contacts;
          }
       }  

        $customerContact = [];
        $remaing_days = 0;
     if(count($renewalsWithcontacts) >= 1){
     	$getContacts = new CronJobController();
		$getContacts->sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts);
		}
		return 'Done';
  }


  public static function getRenewals($percentage) {
	$renewals = Renewal::where('billingBalance','>',0)
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),renewals.end_date ) =  ROUND(ABS(TIMESTAMPDIFF(DAY, renewals.start_date,renewals.end_date ) * ('.$percentage.'/100) ),0)')->with(['contacts','customers'])
         ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
         ->get();
       return $renewals;
}


  public function sendNotificationToContactsAttachedToRenewal($renewalsWithcontacts) {
  	            foreach ($renewalsWithcontacts as $key => $contact) {

		                $customerContact=Contact::where('id',$contact->contact_id)->first();

		   $customerRenewal = Renewal::where('customer_id',$customerContact->customer->id)
		   ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))->first();
		   
		   $remaing_days = (string)$customerRenewal->remaingdays;

		         NotifyDueRenewalJob::dispatch($customerRenewal,$customerContact,$remaing_days)
		    ->delay(now()->addSeconds(5));

		    }
  }

}