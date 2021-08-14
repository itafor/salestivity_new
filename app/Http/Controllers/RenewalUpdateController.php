<?php

namespace App\Http\Controllers;

use App\RenewalUpdate;
use App\RenewalUpdateReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class RenewalUpdateController extends Controller
{
    public function storeUpdate(Request $request){
    	//dd($request->all());
    	$data = $request->all();
    		 $validator = Validator::make($request->all(), [
            'renewal_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'update_date' => 'required',
            'bill_remark' => 'required',
            'commments' => 'required',
        ]);
    	  if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


    	$renewal_update = RenewalUpdate::create([
        'renewal_id' => $data['renewal_id'],
        'user_id' => $data['user_id'],
        'update_date' => Carbon::parse(formatDate($data['update_date'], 'd/m/Y', 'Y-m-d')),
        'type' => isset($data['type']) ? $data['type'] : null,
        'commments' => $data['commments'],
        'bill_remark' => $data['bill_remark'],
        'bill_remark_payment_date' => isset($data['bill_remark_payment_date']) ? Carbon::parse(formatDate($data['bill_remark_payment_date'], 'd/m/Y', 'Y-m-d')) : null,

    	]);
    
      if($renewal_update){
    	return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);
    }else{
    		Alert::error('Ooops', 'Something went wrong. please try again!!');
    	return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);

}

}

public function editRenewalUpdate(Request $request){
        //dd($request->all());
        $data = $request->all();
             $validator = Validator::make($request->all(), [
            'renewal_update_id' => 'required|numeric',
            'renewal_id' => 'required',
            'update_date' => 'required',
            // 'type' => 'required',
            'commments' => 'required',
        ]);
          if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


        $renewal_update = RenewalUpdate::find($data['renewal_update_id'])->update([
        'update_date' => Carbon::parse(formatDate($data['update_date'], 'd/m/Y', 'Y-m-d')),
        'type' => isset($data['type']) ? $data['type'] : null,
        'commments' => $data['commments'],
        'bill_remark' => $data['bill_remark'],
        'bill_remark_payment_date' => isset($data['bill_remark_payment_date']) ? Carbon::parse(formatDate($data['bill_remark_payment_date'], 'd/m/Y', 'Y-m-d')) : null,
        ]);
    
      if($renewal_update){
        return back();// redirect()->route('billing.renewal.show', [$request->renewal_id]);
    }else{
            Alert::error('Ooops', 'Something went wrong. please try again!!');
        return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);

}

}

    public function storeRenewalUpdateReply(Request $request){
        //dd($request->all());
        $data = $request->all();
             $validator = Validator::make($request->all(), [
            'renewal_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'renewal_update_id' => 'required|numeric',
            'reply' => 'required',
        ]);
          if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


        $renewal_update_reply = RenewalUpdateReply::create([
        'renewal_update_id' => $data['renewal_update_id'],
        'user_id' => $data['user_id'],
        'reply' => $data['reply'],
        ]);
    
      if($renewal_update_reply){
        return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);
    }else{
            Alert::error('Ooops', 'Something went wrong. please try again!!');
        return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);

}

}

    public function updateRenewalUpdateReply(Request $request){
        //dd($request->all());
        $data = $request->all();
             $validator = Validator::make($request->all(), [
            'renewal_id' => 'required|numeric',
            'renewal_update_reply_id' => 'required|numeric',
            'reply' => 'required',
        ]);
          if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }


        $renewal_update_reply = RenewalUpdateReply::find($data['renewal_update_reply_id'])->update([
        'reply' => $data['reply'],
        ]);
    
      if($renewal_update_reply){
        return back(); // redirect()->route('billing.renewal.show', [$request->renewal_id]);
    }else{
            Alert::error('Ooops', 'Something went wrong. please try again!!');
        return back(); //redirect()->route('billing.renewal.show', [$request->renewal_id]);

}

}

}
