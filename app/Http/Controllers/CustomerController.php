<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\AddressCustomer;
use App\Contact;
use App\CustomerCorporate;
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
        $userId = auth()->user()->id;
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        // dd($customers->individual->email);
        // $account = Customer::where('id', $id)->first();
        // $addresses = AddressCustomer::where('customer_id', $account->id);
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
    // public function store(Request $request)
    // {
    //     $customer = new Customer;
    //     $address = new AddressCustomer;
    //     $userId = auth()->user()->id;
        
    //     $this->validate($request, [
    //         'company_name' => 'required|max:255|min:2',
    //         'industry' => 'required',
    //         'email' => 'required|max:255',
    //         'phone' => 'required|max:11',
    //         'website' => 'required',
    //         'state' => 'required',
    //         'city' => 'required',
    //         'street' => 'required',
    //         'country' => 'required',
    //     ]);
    //     $customer->company_name = $request->company_name;
    //     $customer->industry = $request->industry;
    //     $customer->email = $request->email;
    //     $customer->phone = $request->phone;
    //     $customer->website = $request->website;
    //     $customer->main_acct_id = $userId;
    //     $customer->save();

    //     $address->customer_id = $customer->id;
    //     $address->state = $request->state;
    //     $address->city = $request->city;
    //     $address->street = $request->street;
    //     $address->country = $request->country;
    //     $address->main_acct_id = $userId;
    //     $address->save();


    //     $status = "Account Added";
    //     Session::flash('status', $status);

    //     return redirect()->route('customer.index');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id;

        $contact->main_acct_id = $userId;
        $customer = Customer::find($id);
        $address = AddressCustomer::where('customer_id', '=', $id)->where('main_acct_id', $userId)->get()->first();
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
        $customer = Customer::find($id);
        $address = AddressCustomer::where('customer_id',$id)->first();
        

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

        $address->customer_id = $customer->id;
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
            $contact->main_acct_id = $userId;
        }

        $contact->save();


        $status = "Account has been successfully updated";
        Session::flash('status', $status);

        return redirect()->route('customer.show', $customer->id);
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
        $customer = CustomerCorporate::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        $contacts = Contact::where('customer_id', $account->id)->get();
        // dd($contacts);

        DB::beginTransaction();
        try {
            // delete all contacts related to this customer 
            if ($contacts !== null){
                foreach($contacts as $contact){
                    $contact->delete();
                }
                $address->delete();
                $account->delete();
                $customer->delete();
            } else {
                $address->delete();
                $account->delete();
                $customer->delete();
            }
            
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            // return response()->json(['error' => $ex->getMessage()], 500);
            $status = "Account not Deleted";
            Session::flash('error', $status);
            return redirect()->route('customer.index');
        }

        // $account->delete();
        // $customer->delete();
        // $address->delete();
        // $contacts->delete();

        Session::flash('status', 'The Customer has been successfully deleted');
        return redirect()->route('customer.index');
    }
}
