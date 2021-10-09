<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{

  public function activatePendingSubscription($user_id, $plan_id, $sub_id)
    {

        $subscriptions = Subscription::where([
            ['user_id', $user_id],
          ])->get();

            if(count($subscriptions)>=1){
                foreach ($subscriptions as $key => $sub) {
                    $sub->status = "Revoked";
                    $sub->save();
                }
            }

          $sub = Subscription::where([
            ['id', $sub_id],
            ['user_id', $user_id],
            ['plan_id', $plan_id]
          ])->first();

            if($sub){
                    $sub->status = "Active";
                    $sub->start_date = Carbon::now('PST');
                    $sub->end_date = Carbon::now('PST')->addYear();
                    $sub->save();
                    return $sub;
            }
    }


    public function revokeActiveSubscription($user_id, $plan_id, $sub_id)
    {

        $sub = Subscription::where([
            ['user_id', $user_id],
            ['plan_id', $plan_id],
            ['id', $sub_id],
          ])->first();

            if($sub){
                    $sub->status = "Revoked";
                    $sub->save();
                }

         return Subscription::create([
            'user_id' => $user_id,
            'reference' => generateUUID(),
            'plan_id' => 1,
            'status' => 'Active',
            'channel' => 'Bank Transfer'
        ]);
         
    }



    public function index()
    {
        $data['plans'] = Plan::all();
        return view('zeus.plans.index', $data);
    }

   public function allSubscriptions()
    {
        $data['subscriptions'] = Subscription::where('status', '!=', 'Revoked')->get();
        return view('zeus.plans.subscriptions', $data);
    }

    public function createPlan()
    {
        return view('zeus.plans.create');
    }

    public function storePlan(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required',
            'number_of_subusers' => 'required',
            'number_of_accounts' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Plan::createNewPlan($request->all());

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');
    }

     public function edit($id)
    {
        $data['plan'] = Plan::findOrFail($id);
        return view('zeus.plans.edit', $data);
    }

        public function updatePlan(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount' => 'required',
            'number_of_subusers' => 'required',
            'number_of_accounts' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Plan::upgradePlan($request->all());

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
    }
}
