<?php
namespace App\Http\Traits;

use App\Http\Controllers\CronJobController;
use App\Renewal;
use Illuminate\Support\Facades\DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

trait RenewalInvoiceTrait {


   public function downloadRenewalInvoice($renewalId){
    
         $renewal = self::getRenewal($renewalId);
      
      $pdf = PDF::loadView('emails.email_invoice_renewal_to_customer', [
            'renewal'=> $renewal, 
            'remaingDays' => $renewal->remaingDays, 
        ]);

        $documentName = 'invoiceRenewal_'.$renewal->invoice_number.'.pdf';

      return $pdf->download($documentName);
   }

      public function resendRenewalInvoice($renewalId){

              self::renewalInvoice($renewalId);

            $status = "Renewal Invoice has been resent successfully";
            Alert::success('Renewal Invoice Resent', $status);
            return back();
   }

   public static function renewalInvoice($renewalId){
      
         $renewal = self::getRenewal($renewalId);

          $renewalContacts = $renewal->contacts;

        CronJobController::notifyCustomer($renewal);

        CronJobController::sendNotificationToContactsAttachedToRenewal($renewalContacts);
   }

   public static function getRenewal($renewalId){

    $renewal = Renewal::where([
        ['id', $renewalId],
      ])
      ->select('renewals.*', DB::raw('TIMESTAMPDIFF(DAY,renewals.start_date,renewals.end_date) AS days'),
     DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date) AS remaingdays'))
     ->first();
   return $renewal;

   }


}