<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Opportunity;
use Carbon\Carbon;

class AjaxController extends Controller
{
    public function getContacts($id)
    {
        $contacts = Contact::where('customer_id', $id)->get();
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

}
