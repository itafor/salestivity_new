<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\AddressCustomer;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        $addresses = AddressCustomer::all();
        return view('customer.index', compact('customers', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer;
        $address = new AddressCustomer;

        $this->validate($request, [
            'company_name' => 'required|max:255|min:2',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:11',
            'website' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);
        $customer->company_name = $request->company_name;
        $customer->industry = $request->industry;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->website = $request->website;
        $customer->save();

        $address->customer_id = $customer->id;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->country = $request->country;

        $address->save();


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
        //
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
        //
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
