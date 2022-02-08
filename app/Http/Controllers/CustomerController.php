<?php

namespace App\Http\Controllers;

use App\AddressCustomer;
use App\City;
use App\Contact;
use App\Customer;
use App\CustomerCorporate;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class CustomerController extends Controller
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
        $guard_object = \getActiveGuardType();
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', $guard_object->main_acct_id)->paginate(20);
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

        $guard_object = \getActiveGuardType();
        $customer = Customer::where('id',$id)->where('main_acct_id',$guard_object->main_acct_id)->first();
        $address = AddressCustomer::where('customer_id', '=', $id)->where('main_acct_id', $guard_object->main_acct_id)->first();
        $contacts = Contact::where('customer_id', $id)->where('main_acct_id', $guard_object->main_acct_id)->get();

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
        $userId = \getActiveGuardType()->main_acct_id;
        $customer = Customer::where('id',$id)->where('main_acct_id',$userId)->first();
        if($customer){
            $address = AddressCustomer::where('customer_id',$customer->id)->where('main_acct_id',$userId)->first();
                 $cityId = isset($address) ? $address->city : null;
                 $cityName= isset($address) ? $address->cityName->name : null;

            $customerType = $customer->customer_type;
            if($customerType == 'Corporate'){
                
        return view('customer.corporate.edit',compact('customer','address','cityId','cityName'));
            }else{


        return view('customer.individual.edit',compact('customer','address','cityId','cityName'));

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

    public function searchCustomersByName(Request $request){
     if($request->get('customer_name'))
     {
      $customer_name = $request->get('customer_name');

      $customers = Customer::where('name','like',"%{$customer_name}%")
      ->where('main_acct_id', getActiveGuardType()->main_acct_id)
    ->get();

    $output ='<ul class="dropdown-menu" 
    style="display: block; 
    position: absolute; z-index: 1; width:300px; padding-left:20px; margin-left:10px; margin-top:-15px;">';
    foreach ($customers as $customer) {
       if($customer->main_acct_id == getActiveGuardType()->main_acct_id){
$output.='<li><a href="/customer/'.$customer->id.'/show"  style="font-size: 14px; color: #000;" ">'.$customer->name.'</a></li>';
 }
    }
   $output .='</ul>';
   if (count($customers) >= 1) {
        echo $output;
   }else{
    echo '';
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
    public function importCustomersForm()
    {
        return view('customer.import_customers');
    }


  public function importCustomers(Request $request) 
    {

        $validator = Validator::make($request->all(),[
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        if($validator->fails()){


             $status =   $validator->errors()->all();
        Alert::error('Validation Error', implode('', $status));
                
         return back();
        }
        try {
        
        Excel::import(new CustomersImport,request()->file('file')->store('temp'));

          
         $status = "Customers has been successfully imported";
       
        Alert::success('status', $status);
                
         return back();
            
        } catch (Exception $e) {

             $status = $e->getMessage();
       
                 Alert::error('status', $status);

         return back();

        }
      
             
    }
}
