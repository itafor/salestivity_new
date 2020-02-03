<?php

namespace App\Http\Controllers;

use App\BillingAgent;
use App\Customer;
use Illuminate\Http\Request;
use Validator;

class BillingAgentController extends Controller
{
    public function index(){
    	$userId = auth()->user()->id;
        $billing_agents = BillingAgent::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();

        return view('billing.agents.index', compact('billing_agents'));
    }

    public function create(){

    	$userId = auth()->user()->id;
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();

        return view('billing.agents.create', compact('customers'));
    }

    public function store(Request $request){
    	//dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|numeric',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        DB::beginTransaction();
        try{
         $billingAgent =   BillingAgent::createNew($request->all());
        
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Add Billing Agent', 'An attempt to add billing agent failed');
         return back()->withInput();
            
        }
        
        Alert::success('Add Billing Agent', 'Billing Agent added successfully');
        return redirect()->route('billing.agent.index');
        
    }
}
