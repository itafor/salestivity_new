<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AddressCustomer;
use App\CustomerCorporate;
use App\Customer;
use App\Industry;
use App\Contact;
use App\Country;
use App\State;
use Session;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Stevebauman\Location\Facades\Location;

class CustomerCorporateController extends Controller
{

      public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except('homepage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ip = $request->ip();
        if($ip == '127.0.0.1'){
            $ip = '105.112.24.184';
        }

        // get location of user
        $loc = Location::get($ip);
        $location = $loc->countryCode;
        // dd($location);

        // default the country, states and city to these values
        $getCountry = Country::where('sortname', $location)->first();
        // dd($getCountry);
        $states = State::where('country_id', $getCountry->id)->get();
        return view('customer.corporate.create', compact('getCountry', 'location', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $validator = Validator::make($request->all(), [
            'company_name' => 'required|max:255|min:2',
            'industry' => 'required',
            'company_email' => 'required|max:255',
            'company_phone' => 'required',
            'turn_over' => 'required',
            'employee_count' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);

         if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }
        
    DB::beginTransaction();
        try{
         $account =   Customer::createCorporateCustomer($request->all());

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Add Corporate Account', 'An attempt to add create new account failed');
         return back()->withInput();
            
        }
        
        Alert::success('Add Corporate Account', 'Account added');

        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;

        $industries = Industry::all();
        $countries = Country::all();
        $customer = Customer::where('id',$id)->where('account_type', 1)->where('main_acct_id', $userId)->first();
        //dd($customer);
        $address = AddressCustomer::where('customer_id', $customer->id)->first();
        $contacts = Contact::where('customer_id', $customer->id)->get();
        return view('customer.corporate.show', compact('customer', 'address', 'contacts', 'countries', 'industries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       //dd($request->all());

         $validator = Validator::make($request->all(), [
            'company_name' => 'required|max:255|min:2',
            'industry' => 'required',
            'company_email' => 'required|max:255',
            'company_phone' => 'required',
            'website' => 'required',
            'turn_over' => 'required',
            'employee_count' => 'required',
            'state' => 'required',
            // 'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);

         if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }
        
    DB::beginTransaction();
        try{
         $account =   Customer::updateCorporateCustomerAcount($request->all());

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Update Corporate Account', 'An attempt to update create account failed');
         return back()->withInput();
            
        }
        
        Alert::success('Update Corporate Account', 'Account updated');

        return redirect()->route('customer.edit',$request->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
   }

}
