<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Subscription;
use Illuminate\Http\Request;
use Validator;

class SubscriptionsController extends Controller
{

     public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except(['']);
    }
    
     public function getPlans()
    {
        $data['plans'] = Plan::all();

        return view('subscription.plans', $data);
    }

     public function fetchPlanDetails($id)
    {
        $plan = Plan::where('id', $id)->first();
        return response()->json(['plan' => $plan]);
    }

    public function updatePlan(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        $this->revokePendingSubscriptions();

       $sub = Subscription::upgradePlan($data);
       if($sub){
        return back()->withSuccess('Plan upgrade request submitted successfully. Currenly pending for approval.');

    }else{
        return back()->withFail('Something went wrong! Try again later');
    }
    }

    public function revokePendingSubscriptions()
    {
          $subscriptions = Subscription::where([
            ['user_id', getActiveGuardType()->main_acct_id],
            ['status', 'Pending']
          ])->get();

            if(count($subscriptions)>=1){
                foreach ($subscriptions as $key => $sub) {
                    $sub->status = "Revoked";
                    $sub->save();
                }
            }
    }

}
