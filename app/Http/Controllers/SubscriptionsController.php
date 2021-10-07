<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Subscription;
use Illuminate\Http\Request;
use Validator;

class SubscriptionsController extends Controller
{
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

       $sub = Subscription::upgradePlan($data);
       if($sub){
        return back()->with('success', 'Plan updated successfully');

    }else{
        return back()->with('erroe', 'Something went wrong! Try again later');
    }
    }
}
