<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\AddressCustomer;
use App\Contact;
use App\CustomerCorporate;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        return view('customer.index', compact('customers'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $userId = auth()->user()->id;

        $customer = Customer::where('id',$id)->where('main_acct_id',$userId)->first();
        $address = AddressCustomer::where('customer_id', '=', $id)->where('main_acct_id', $userId)->first();
        $contacts = Contact::where('customer_id', $id)->where('main_acct_id', $userId)->get();
        // dd($contacts);
        return view('customer.show', compact('customer', 'address', 'contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function destroy($id)
    {
    $customer = Customer::find($id);
    if($customer){
        Customer::deleteContacts($customer->id);
        Customer::deleteAddress($customer->id);
   $customer->delete();
    }
 }
  public function deleteContact($id)
    {
    $contact = Contact::find($id);
    if($contact){
   $contact->delete();
    }
 }
}
