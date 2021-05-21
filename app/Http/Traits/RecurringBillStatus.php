<?php
namespace App\Http\Traits;

use App\Http\Controllers\CronJobController;
use App\Mail\ConfirmRecurringInvoiceRecceipt;
use App\Renewal;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

trait RecurringBillStatus {


public function confirmRecurringInvoiceReceipt($renewal_id){
    $renewal = Renewal::find($renewal_id);

    if($renewal->bill_status == 'Confirmed'){
        return 'Already confirmed!!';
    }else{

        CronJobController::update_renewal_bill_status_to_confirmed($renewal);

           $toEmail = $renewal->user->email;

        Mail::to($toEmail)->send(new ConfirmRecurringInvoiceRecceipt($renewal));

        return 'Confirmed successfully!!';

    }
}

   public function changeBillStatusToConfirmed($renewal_id){
        $renewal = Renewal::find($renewal_id);

        if($renewal->bill_status == 'Confirmed'){
             Alert::success('Bill Status', 'Bill status already changed to confirmed');
    return redirect()->route('billing.renewal.show',$renewal_id);
        }else{

            CronJobController::update_renewal_bill_status_to_confirmed($renewal);

             Alert::success('Bill Status', 'Bill status changed to confirmed!!');
    return redirect()->route('billing.renewal.show',$renewal_id);
        }
}

  public function changeBillStatusToSent($renewal_id){
        $renewal = Renewal::find($renewal_id);
        // dd($renewal);
        if($renewal->bill_status == 'Sent'){
             Alert::success('Bill Status', 'Bill status already changed to sent');
    return redirect()->route('billing.renewal.show',$renewal_id);
        }else{

            CronJobController::update_renewal_bill_status_to_sent($renewal);

             Alert::success('Bill Status', 'Bill status changed to sent!!');
    return redirect()->route('billing.renewal.show',$renewal_id);
        }
}

}