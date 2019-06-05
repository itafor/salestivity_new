<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AddressCustomer;
use App\CustomerCorporate;
use App\Customer;
use App\Industry;
use App\Contact;
use Session;

class CustomerCorporateController extends Controller
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
        $industries = Industry::all();
        return view('customer.corporate.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new CustomerCorporate;
        $account = new Customer;
        $address = new AddressCustomer;
        $contact = new Contact;

        $this->validate($request, [
            'company_name' => 'required|max:255|min:2',
            'industry' => 'required',
            'email' => 'required|max:255',
            'phone' => 'required|max:11',
            'website' => 'required',
            'turn_over' => 'required',
            'employee_count' => 'required',
            'state' => 'required',
            'contact_phone' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
        ]);
        $customer->company_name = $request->company_name;
        $customer->industry = $request->industry;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->website = $request->website;
        $customer->turn_over = $request->turn_over;
        $customer->employee_count = $request->employee_count;
        $customer->save();

        $account->name = $request->company_name;
        $account->account_type = $request->account_type;
        $account->account_id = $customer->id;
        $account->save();

        $address->customer_id = $account->id;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->country = $request->country;
        $address->save();

        // $contact->customer_id = $account->id;
        // $contact->title = $request->title;
        // $contact->surname = $request->surname;
        // $contact->name = $request->name;
        // $contact->email = $request->contact_email;
        // $contact->phone = $request->contact_phone;
        // $contact->save();

        // $contact = new Contact;

        foreach($request->contact_title as $title)
        {
            $contact->customer_id = $account->id;
            $contact->title = $title;
        }

        foreach($request->contact_surname as $surname)
        {
            $contact->surname = $surname;          
        }

        foreach($request->contact_phone as $phone)
        {
            $contact->phone = $phone;
        }

        foreach($request->contact_name as $name)
        {
            $contact->name = $name;
        }

        foreach($request->contact_email as $email)
        {
            $contact->email = $email;
        }

        $contact->save();


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
        $customer = Customer::where('account_id',$id)->where('account_type', 1)->first();
        $address = AddressCustomer::where('customer_id', $customer->id)->first();
        $contacts = Contact::where('customer_id', $customer->id)->get();
        return view('customer.corporate.show', compact('customer', 'address', 'contacts'));
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
        $account = Customer::where('id', $id)->where('account_type', 1)->first();
        $customer = CustomerCorporate::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        // dd($address);
        $contacts = Contact::where('customer_id', $account->id)->first();
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
        $customer->company_name = $request->input('company_name');
        $customer->industry = $request->input('industry');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->website = $request->input('website');
        $customer->save();

        // $address->customer_id = $customer->id;
        $address->state = $request->input('state');
        $address->city = $request->input('city');
        $address->street = $request->input('street');
        $address->country = $request->input('country');

        // dd($address);

        $address->save();

        $contact = new Contact;

        foreach($request->customer_id as $customer_id)
        {
            $contact->customer_id = $customer_id;
        }

        foreach($request->contact_title as $title)
        {
            $contact->title = $title;
        }

        foreach($request->contact_surname as $surname)
        {
            $contact->surname = $surname;          
        }

        foreach($request->contact_phone as $phone)
        {
            $contact->phone = $phone;
        }

        foreach($request->contact_name as $name)
        {
            $contact->name = $name;
        }

        foreach($request->contact_email as $email)
        {
            $contact->email = $email;
        }

        $contact->save();


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
        dd($account);
        $customer = CustomerCorporate::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        $contacts = Contact::where('customer_id', $account->id)->first();

        $customer->delete();
        $address->delete();
        $contacts->delete();

        Session::flash('status', 'The Customer has been successfully deleted');
        return redirect()->route('customer.index');
    }
}
