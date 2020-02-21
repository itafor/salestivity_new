<?php

namespace App\Http\Controllers;

use App\BillingAgent;
use App\Category;
use App\Contact;
use App\Customer;
use App\Jobs\SendRenewalPaymentNotification;
use App\Mail\RenewalPaid;
use App\Payment;
use App\Product;
use App\Renewal;
use App\RenewalPayment;
use App\SubCategory;
use App\renewalContactEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\RenewalCreated;
use App\User;
use Session;
use Validator;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $renewals = Renewal::where('main_acct_id', $userId)
        ->orderby('created_at','desc')
        ->get();
        return view('billing.renewal.index', compact('renewals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = auth()->user()->id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('billing.renewal.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|numeric',
            'product' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        if(compareEndStartDate($request->start_date,$request->end_date) == false){
            Alert::error('Invalid End Date', 'Please ensure that the End Date is after the Start Date');
         return back()->withInput();
        }

        DB::beginTransaction();
        try{
            // $user = auth()->user();
            $when = now()->addSeconds(5);
            $emails = [];
         $renewal = Renewal::createNew($request->all());
         $getContactEmail = renewalContactEmail::where('renewal_id', $renewal->id)->get();
            foreach ($getContactEmail as $key => $contact) {
                $con = Contact::where('id', $contact->contact_id)->first();
                // $user->notify(new RenewalCreated($renewal));
                (new User)->forceFill([
                    'name' => $con->name,
                    'email' => $con->email,
                    ])->notify((new RenewalCreated($renewal))->delay($when));
                    // ])->notify(new RenewalCreated($renewal));
            }

            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Renewal Addition Failed', 'An attempt to add renewal failed');
         return back()->withInput();
            
        }
        
        Alert::success('Add Renewal', 'Renewal added successfully');
        return redirect()->route('billing.renewal.index');
    }

    public function mail()
    {
        return view('emails.renewal_created_notification');
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
        $renewalPayments='';
        $renewal = Renewal::where('id',$id)
        ->where('main_acct_id', $userId)
        ->whereNull('deleted_at')->first();
       
        if($renewal){
         $renewalPayments = RenewalPayment::where('renewal_id',$renewal->id)->where('main_acct_id', $userId)->get();
        }
         
       
        return view('billing.renewal.show', compact('renewal','renewalPayments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $userId = auth()->user()->id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        $renewal = Renewal::where('id',$id)->first();
        return view('billing.renewal.edit', compact('renewal','customers', 'products'));
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
        $validator = Validator::make($request->all(), [
            'renewal_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'product' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        if(compareEndStartDate($request->start_date,$request->end_date) == false){
            Alert::error('Invalid End Date', 'End Date cannot be less than start date');
         return back()->withInput();
        }

        DB::beginTransaction();
        try{
            Renewal::updateRenewal($request->all());
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Renewal Update Failed', 'An attempt to edit the selected renewal failed');
         return back()->withInput();
            
        }
        
        Alert::success('Renewal Update successful', 'Renewal updated successfully');
        return redirect()->route('billing.renewal.show', $request->renewal_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $renewal = Renewal::find($id);
         RenewalPayment::deletePaymentHistory($renewal->id);
         $renewal->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($id)
    {
        $userId = auth()->user()->id;
        $renewal = Renewal::where('id', $id)->where('main_acct_id', $userId)->first();
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $sub_categories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('billing.renewal.manage', compact('renewal', 'customers', 'products', 'categories', 'sub_categories'));
    }

    /**
     * Store a newly created payment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
         //dd($request->all());
        $validator = Validator::make($request->all(), [
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'billingbalance' => 'required',
            'customer_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'renewal_id' => 'required|numeric',
            'payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        DB::beginTransaction();
        try{
         $renewal =  RenewalPayment::createNew($request->all());
             $toEmail = $renewal->customer->email;
        //$billingAgent = BillingAgent::where('customer_id',$renewal->customer_id)->first();
         $payment_status =RenewalPayment::where('id',$renewal->id)->first();
         $renewalcontacts =renewalContactEmail::where('renewal_id',$renewal->renewal_id)->get();

            Mail::to($toEmail)->send(new RenewalPaid($renewal,$payment_status));
            if($renewalcontacts){
                    foreach ($renewalcontacts as $key => $contact) {
                        $customerContactEmail=Contact::where('id',$contact->contact_id)->first();
        SendRenewalPaymentNotification::dispatch($renewal,$customerContactEmail,$payment_status)
            ->delay(now()->addSeconds(5));
            }
        }
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Renewal Payment', 'An attempt to record renewal payment failed');
         return back()->withInput();
            
        }
        
        Alert::success('Renewal Payment', 'Renewal payment recorded successfully');
        return redirect()->route('billing.renewal.show',$request->renewal_id);
    }
}
