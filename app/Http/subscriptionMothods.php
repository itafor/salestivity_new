<?php

use App\Customer;
use App\SubUser;
use App\Subscription;


  function mySubscriptionStatus($plan_id){
        $subscription = Subscription::where([
            ['user_id', getActiveGuardType()->main_acct_id],
            ['status', "!=", 'Revoked'],
            ['plan_id', $plan_id]
          ])->first();

       if ($subscription) {
           return $subscription->status;
       }
    }

    function autoFreeSubscription()
    {
          	$data = ['plan_id' => 1, 'status' => 'Active'];

    	  $subscriptions = Subscription::where([
            ['user_id', getActiveGuardType()->main_acct_id],
          ])->get();
          if(count($subscriptions) <= 0){
    	Subscription::upgradePlan($data);
          }
    }

    function usersCount()
    {
    	 $subusers = SubUser::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
          ])->get();

    	 return count($subusers);
    }

      function customerCount()
    {
       $customers = Customer::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
          ])->get();

       return count($customers);
    }

    function activeSubscription()
    {
    	 $subscription = Subscription::where([
            ['user_id', getActiveGuardType()->main_acct_id],
            ['status', 'Active']
          ])->first();

    	 if($subscription){
    	 	return [
    	 		'plan' => $subscription->plan
    	 	];
    	 }

    }