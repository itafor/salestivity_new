<?php

namespace App\Http\Controllers;

use App\Customer;
use App\EmailMarketing;
use App\Mail\EmailMarketingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class EmailMarketingController extends Controller
{
    
    public function createNewEmail(Request $request){

    	return view('emailMarketing.create');
    }

    public function sendNewEmail(Request $request){

    	  $data = $request->all();

    	  $validator = Validator::make($request->all(), [
			'subject' => 'required',
            'message' => 'required',
                ]);

              if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }

    	$customers = Customer::all();

    	foreach ($customers as $key => $customer) {
            Mail::to($customer->email)->queue(new EmailMarketingMail($customer, $data));
    	}

    $storeEmail = EmailMarketing::newMessage($data);

    	 if($storeEmail){
    	 	 Alert::success('Email Sent', 'Email sent successfully!!');
            return back()->withInput();
    	 }
           
    }

    public function listEmails(Request $request){

    		$data['mails'] = EmailMarketing::where('main_acct_id',  getActiveGuardType()->main_acct_id)->paginate(10);
   		
    	return view('emailMarketing.list', $data);
    }

      public function showEmail($emai_id){

    		$data['mail'] = EmailMarketing::where('id',  $emai_id)->first();
   		
    	return view('emailMarketing.show', $data);
    }


    
}
