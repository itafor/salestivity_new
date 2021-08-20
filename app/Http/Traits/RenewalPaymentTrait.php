<?php

namespace App\Http\Traits;

use App\Contact;
use App\Jobs\SendRenewalPaymentNotification;
use App\Mail\RenewalPaid;
use App\RenewalPayment;
use App\renewalContactEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

trait RenewalPaymentTrait {

	public function pay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'billingbalance' => 'required',
            'customer_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'renewal_id' => 'required|numeric',
            'payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        DB::beginTransaction();
        try{
         $renewal_payment =  RenewalPayment::createNew($request->all());
        $this->sendPaymentReceiptToCustomer($renewal_payment);
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Renewal Payment', 'An attempt to record renewal payment failed');
         return back()->withInput();
            
        }
        
        $paymentStatus = renewalPaymentStatus($renewal_payment->renewal);
        Alert::success('Renewal Payment', 'Renewal payment recorded successfully');
        
        return redirect()->route('billing.renewal.show',[$request->renewal_id, $paymentStatus, 'next']);
    }


    public function sendPaymentReceiptToCustomer($renewal_payment){

    	     $toEmail = $renewal_payment->customer->email;
        
         $payment_status =RenewalPayment::where('id',$renewal_payment->id)->first();
         $renewalcontacts =renewalContactEmail::where('renewal_id',$renewal_payment->renewal_id)->get();

            Mail::to($toEmail)->queue(new RenewalPaid($renewal_payment,$payment_status));

            if($renewalcontacts){
                    foreach ($renewalcontacts as $key => $contact) {
                        $customerContactEmail=Contact::where('id',$contact->contact_id)->first();
        SendRenewalPaymentNotification::dispatch($renewal_payment,$customerContactEmail,$payment_status)
            ->delay(now()->addSeconds(5));
            }
        }
    }

public function resendRenwalPaymentReceipt($renewal_payment_id){

         $renewal_payment =RenewalPayment::where('id', $renewal_payment_id)->first();

        $this->sendPaymentReceiptToCustomer($renewal_payment);

         Alert::success('Resend Renewal Payment', 'Renewal payment receipt resent.');
        return back();// redirect()->route('billing.renewal.show',$renewal_payment->renewal->id);
}

}