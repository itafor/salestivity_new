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
use Session;
use DB;

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
        $countries = Country::all();
        return view('customer.corporate.create', compact('industries', 'countries'));
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
        $userId = auth()->user()->id;
        // $contact->main_acct_id = $userId;

        $this->validate($request, [
        //     'company_name' => 'required|max:255|min:2',
        //     'industry' => 'required',
        //     'company_email' => 'required|max:255',
        //     'phone' => 'required|max:11',
        //     'website' => 'required',
        //     'turn_over' => 'required',
        //     'employee_count' => 'required',
        //     'state' => 'required',
        //     'city' => 'required',
        //     'street' => 'required',
        //     'country' => 'required',
        ]);
        // dd($request);

        // use transaction to make sure all requests has been saved or else roll back the transaction
        DB::beginTransaction();
        try {
            $customer->company_name = $request->company_name;
            $customer->industry = $request->industry;
            $customer->email = $request->company_email;
            $customer->phone = $request->company_phone;
            $customer->website = $request->website;
            $customer->turn_over = $request->turn_over;
            $customer->employee_count = $request->employee_count;
            $customer->main_acct_id = $userId;
            $customer->save();
            
            
            $account->name = $request->company_name;
            $account->account_type = $request->account_type;
            $account->account_id = $customer->id;
            $account->main_acct_id = $userId;
            $account->save();
            
            
            // dd($customer->id);
            
            $address->customer_id = $account->id;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->street = $request->street;
            $address->country = $request->country;
            $address->main_acct_id = $userId;
            $address->save();
            
            
            $contact->customer_id = $account->id;
            $contact->title = $request->title;
            $contact->surname = $request->surname;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->main_acct_id = $userId;
            $contact->save();
            DB::commit();

        
        } catch (\Exception $ex) {
            DB::rollback();
            // return response()->json(['error' => $ex->getMessage()], 500);
            $status = "Account not Added";
            Session::flash('error', $status);
            return redirect()->route('customer.index');
        }
        
        
        
        $addContact = new Contact;
        
        // if more contacts are being added
        $addTitle = $request->contact_title;
        $addSurname = $request->contact_surname;
        $addPhone = $request->contact_phone;
        $addName = $request->contact_name;
        $addEmail = $request->contact_email;
        
        // dd($request->all());
        
        if($addTitle || $addSurname || $addPhone || $addName || $addEmail) {
            
            foreach($request->contact_title as $title)
            {
                $addContact->customer_id = $account->id;
                $addContact->title = $title;
            }
            
            foreach($request->contact_surname as $surname)
            {
                $addContact->surname = $surname;          
            }
            
            foreach($request->contact_phone as $phone)
            {
                $addContact->phone = $phone;
            }
            
            foreach($request->contact_name as $name)
            {
                $addContact->name = $name;
            }
            
            foreach($request->contact_email as $email)
            {
                $addContact->email = $email;
                $addContact->main_acct_id = $userId;
            }
            
            $addContact->save();
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
        $userId = auth()->user()->id;

        $industries = Industry::all();
        $countries = Country::all();
        $customer = Customer::where('account_id',$id)->where('account_type', 1)->where('main_acct_id', $userId)->first();
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
        $customer->employee_count = $request->input('employee_count');
        $customer->turn_over = $request->input('turn_over');
        $customer->save();

        // $address->customer_id = $customer->id;
        $address->state = $request->input('state');
        $address->city = $request->input('city');
        $address->street = $request->input('street');
        $address->country = $request->input('country');

        // dd($address);

        $address->save();

        // 
        // $contact = new Contact;

        // foreach($request->customer_id as $customer_id)
        // {
        //     $contact->customer_id = $customer_id;
        // }

        // foreach($request->contact_title as $title)
        // {
        //     $contact->title = $title;
        // }

        // foreach($request->contact_surname as $surname)
        // {
        //     $contact->surname = $surname;          
        // }

        // foreach($request->contact_phone as $phone)
        // {
        //     $contact->phone = $phone;
        // }

        // foreach($request->contact_name as $name)
        // {
        //     $contact->name = $name;
        // }

        // foreach($request->contact_email as $email)
        // {
        //     $contact->email = $email;
        // }

        // $contact->save();


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
        // dd($account);
        $customer = CustomerCorporate::where('id', $account->account_id)->first();
        $address = AddressCustomer::where('customer_id', $account->id)->first();
        $contacts = Contact::where('customer_id', $account->id)->get();
        // dd($contacts);

        // dd($account);

        DB::beginTransaction();
        try {
            // delete all contacts related to this customer 
            if ($contacts !== null){
                foreach($contacts as $contact){
                    $contact->delete();
                }
                $account->delete();
                $customer->delete();
                $address->delete();
            } else {
                $account->delete();
                $customer->delete();
                $address->delete();
            }
            
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            // return response()->json(['error' => $ex->getMessage()], 500);
            $status = "Account not Deleted";
            Session::flash('error', $status);
            return redirect()->route('customer.index');
        }

        // $customer->delete();
        // $address->delete();
        // $contacts->delete();

        Session::flash('status', 'The Customer has been successfully deleted');
        return redirect()->route('customer.index');
    }
}
