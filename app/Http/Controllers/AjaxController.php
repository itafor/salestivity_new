<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Opportunity;
use App\Department;
use App\Unit;
use App\Product;
use Carbon\Carbon;
use App\State;
use App\City;

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
