<?php

namespace App\Http\Controllers;

use App\City;
use App\Contact;
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
