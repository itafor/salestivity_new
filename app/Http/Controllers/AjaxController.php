<?php

namespace App\Http\Controllers;

use App\City;
use App\Contact;
use App\Customer;
use App\Department;
use App\Opportunity;
use App\Product;
use App\Renewal;
use App\State;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getContacts($id)
    {
        $userId = auth()->user()->id;
        $contacts = Contact::where('customer_id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['contacts' => $contacts]);
    }

    public function getOpportunities($id)
    {
        if($id == 1){
            $opportunities = Opportunity::all();
            
            return response()->json(['opportunities' => $opportunities]);
        } elseif($id == 2) {
            dd(Carbon::today());
        }
    }

    public function getDept($id)
    {

        $userId = auth()->user()->id;
        $units = Unit::where('dept_id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['units' => $units]);
    }
    
    public function getProductPrice($id)
    {
        $userId = auth()->user()->id;
        $products = Product::where('id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['products' => $products]);
    }
     
     public function fetchSelectedProductPrice($id)
    {
        $userId = auth()->user()->id;
        $products = Product::where('id', $id)->where('main_acct_id', $userId)->first();
        return response()->json(['products' => $products]);
    }

     public function fetchRenewalDetails($id)
    {
        $userId = auth()->user()->id;
        $renewal = Renewal::where('id', $id)->where('main_acct_id', $userId)->first();
        return response()->json(['renewal' => $renewal]);
    }
    
    public function validateSelectedPaymentDate($selected_date){

        $payment_date = str_replace("-","/",$selected_date);
        date_default_timezone_set("Africa/Lagos");
        $pay_date   = Carbon::parse(formatDate($payment_date, 'd/m/Y', 'Y-m-d'));
        $today = Carbon::now()->format('d/m/Y');
        $current_timestamp = Carbon::parse(formatDate($today, 'd/m/Y', 'Y-m-d'));

    if($pay_date > $current_timestamp){
        return 'invalidate';
    }
    }

public function increaseStartDatebyOneYear($selected_date){

        $startDate = str_replace("-","/",$selected_date);
       $increased_date = Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d'))->addYear()->format('d/m/Y');

        return $increased_date;
    }
public function getContactEmails($id) {
    $customer = Customer::where('id',$id)->first();
    $contacts = $customer->contacts;
        return response()->json(['contacts' => $contacts]);
}

    public function getSalesDept($id)
    {

        $userId = auth()->user()->id;
        $depts = Department::where('id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['depts' => $depts]);
    }

    public function getState($id)
    {
        $states = State::where('country_id', $id)->get();
        return response()->json(['states' => $states]);
    }

    public function getCity($id)
    {
        $cities = City::where('state_id', $id)->get();
        return response()->json(['cities' => $cities]);
    }


}
