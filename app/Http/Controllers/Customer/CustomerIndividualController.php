<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\CustomerIndividual;
use App\Customer;
use App\AddressCustomer;
use App\State;
use App\Contact;
use App\Country;
use App\Industry;
use Session;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Stevebauman\Location\Facades\Location;

class CustomerIndividualController extends Controller
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
        $countries = Country::all();
        $industries = Industry::all();
        return view('customer.individual.create', compact('countries', 'getCountry', 'location', 'industries', 'states'));
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
            'first_name' => 'required|max:255|min:2',
            'last_name' => 'required|max:255|min:2',
            'profession' => 'required',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
            ]);
            // dd($validator);

         if ($validator->fails()) {
            // Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput()->withErrors($validator->errors());
        }
    
     DB::beginTransaction();
        try{
         $account =   Customer::createIndividualCustomer($request->all());

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Add Individual Account', 'An attempt to add create new account failed');
         return back()->withInput();
            
        }
        
        Alert::success('Add Individual Account', 'Account added');

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
        // the value 2 is used as a parameter because it denotes customer type of 'individual' in the DB
        $customer = Customer::where('account_id',$id)->where('account_type', 2)->first();
        $address = AddressCustomer::where('customer_id', $customer->id)->first();
        $countries = Country::all();
        $industries = Industry::all();
        return view('customer.individual.show', compact('customer', 'address', 'industries', 'countries'));
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
      // dd($request->all());

         $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'profession' => 'required',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required',
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
         $account =   Customer::updateIndividualCustomerAcount($request->all());

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Update Individual Account', 'An attempt to update create account failed');
         return back()->withInput();
            
        }
        
        Alert::success('Update Individual Account', 'Account updated');

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
    //
}

}
