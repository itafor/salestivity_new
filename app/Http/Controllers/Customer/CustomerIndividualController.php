<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\CustomerIndividual;
use App\Customer;
use App\AddressCustomer;
use App\Contact;
use App\Country;
use App\Industry;
use Session;
use DB;

class CustomerIndividualController extends Controller
{
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
    public function create()
    {
        $countries = Country::all();
        $industries = Industry::all();
        return view('customer.individual.create', compact('countries', 'industries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new CustomerIndividual;
        $account = new Customer;
        $address = new AddressCustomer;
        $userId = auth()->user()->id;


        // $input = request()->all();
        // $rules = [
        //     'first_name' => 'required|max:255|min:2',
        //     'last_name' => 'required|max:255|min:2',
        //     'industry' => 'required',
        //     'profession' => 'required',
        //     'email' => 'required|max:255',
        //     'phone' => 'required|max:11',
        //     'website' => 'required',
        //     'state' => 'required',
        //     'city' => 'required',
        //     'street' => 'required',
        //     'country' => 'required',
        // ];
        // $message = [
        //     'first_name.required' => 'First Name is required',
        //     'destination_warehouse_id.required' => 'Destination Warehouse is required',
        //     'produce_id.required' => 'Produce is required',
        //     'quantity.required' => 'Quantity is required',
        //     // 'large_producer_id.required' => 'Producer is required',
        //     // 'input_id.required' => 'Input type is required',
        // ];
        // $validator = Validator::make($input, $rules, $message);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        $this->validate($request, [
            'first_name' => 'required|max:255|min:2',
            'last_name' => 'required|max:255|min:2',
            'profession' => 'required',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:11',
            // 'website' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);

// dd($request);
    DB::beginTransaction();
    try {
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->profession = $request->profession;
        $customer->industry = $request->industry;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->website = $request->website;
        $customer->main_acct_id = $userId;
        $customer->save();
        
        $account->name = $request->first_name;
        $account->account_type = $request->account_type;
        $account->account_id = $customer->id;
        $account->main_acct_id = $userId;
        $account->save();
        
        $address->customer_id = $account->id;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->country = $request->country;
        $address->main_acct_id = $userId;
        $address->save();
        
        DB::commit();
        
        } catch (\Exception $ex) {
            DB::rollback();
            // return response()->json(['error' => $ex->getMessage()], 500);
            $status = "Account not Added";
            Session::flash('error', $status);
            return redirect()->route('customer.index');
        }


        $status = "Account Added";
        Session::flash('status', $status);

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
    public function update(Request $request, $id)
    {
        $account = Customer::where('id', $id)->where('account_type', 2)->first();
        $customer = CustomerIndividual::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        // dd($address);
        $contacts = Contact::where('customer_id', $account->id)->first();
        $this->validate($request, [
            'first_name' => 'required|max:255|min:2',
            'last_name' => 'required|max:255|min:2',
            'profession' => 'required',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:11',
            // 'website' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);
        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        $customer->profession = $request->input('profession');
        $customer->industry = $request->input('industry');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->website = $request->input('website');
        $customer->save();

        $address->state = $request->input('state');
        $address->city = $request->input('city');
        $address->street = $request->input('street');
        $address->country = $request->input('country');
        $address->save();

        $status = "Account has been successfully updated";
        Session::flash('status', $status);

        return redirect()->route('customer.index', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $account = Customer::find($id);
        $customer = CustomerIndividual::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        // dd($address);
        // dd($account);

        DB::beginTransaction();
        try {
                $account->delete();
                $customer->delete();
                $address->delete();
            
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            // return response()->json(['error' => $ex->getMessage()], 500);
            $status = "Account not Deleted";
            Session::flash('error', $status);
            return redirect()->route('customer.index');
        }

            $status = "Account has been successfully Deleted";
            Session::flash('status', $status);
            return redirect()->route('customer.index');


    }
}
