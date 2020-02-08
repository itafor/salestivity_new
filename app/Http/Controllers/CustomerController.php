<?php

namespace App\Http\Controllers;

use App\AddressCustomer;
use App\City;
use App\Contact;
use App\Customer;
use App\CustomerCorporate;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', authUserId())->get();
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

        $customer = Customer::where('id',$id)->where('main_acct_id',authUserId())->first();
        $address = AddressCustomer::where('customer_id', '=', $id)->where('main_acct_id', authUserId())->first();
        $contacts = Contact::where('customer_id', $id)->where('main_acct_id', authUserId())->get();
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
        $customer = Customer::where('id',$id)->where('main_acct_id',authUserId())->first();
        if($customer){
            $customerType = $customer->customer_type;
            if($customerType == 'Corporate'){
                $address = AddressCustomer::where('customer_id',$customer->id)->where('main_acct_id',authUserId())->first();
                 $cityId = $address->city;
                 $cityName= $address->cityName->name;
        return view('customer.corporate.edit',compact('customer','address','cityId','cityName'));
            }else{


        return view('customer.individual.edit');

            }
        }
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
