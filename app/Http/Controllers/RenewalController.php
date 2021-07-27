<?php

namespace App\Http\Controllers;

use App\BillingAgent;
use App\Category;
use App\CompanyAccountDetail;
use App\CompanyEmail;
use App\Contact;
use App\Customer;
use App\Http\Controllers\CronJobController;
use App\Http\Traits\RecurringBillStatus;
use App\Http\Traits\RenewalInvoiceTrait;
use App\Http\Traits\RenewalPaymentTrait;
use App\Jobs\SendRenewalPaymentNotification;
use App\Mail\ConfirmRecurringInvoiceRecceipt;
use App\Mail\RenewalPaid;
use App\Notifications\RenewalCreated;
use App\Payment;
use App\Product;
use App\Renewal;
use App\RenewalPayment;
use App\RenewalUpdate;
use App\SubCategory;
use App\User;
use App\renewalContactEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class RenewalController extends Controller
{
    use RenewalInvoiceTrait, RecurringBillStatus, RenewalPaymentTrait;

      public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except(['confirmRecurringInvoiceReceipt']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $guard_object = getActiveGuardType();
        $userId = auth()->user()->id;
        $data['renewals'] = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('end_date','asc')->with(['customers','prod'])->get();

        return view('billing.renewal.index', $data);
    }

public function getBillingRenewals($id)
    {
        switch ($id) {
            case 'all':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('end_date','asc')->with(['customers','prod'])->get();

        return view('billing.renewal.index', compact('renewals'));

                break;
     case 'outstanding':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Pending']
        ])->orderby('created_at','asc')->with(['customers','prod'])->get();
        return view('billing.renewal.outstanding', compact('renewals'));
                
                break;
     case 'paid':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Paid']
        ])->orderby('created_at','asc')->with(['customers','prod'])->get();
        return view('billing.renewal.paid', compact('renewals'));
                
                break;
       case 'partly_paid':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Partly paid']
        ])->orderby('created_at','asc')->with(['customers','prod'])->get();
        return view('billing.renewal.partly_paid', compact('renewals'));
                
                break;
     case 'due':
            $renewals = Renewal::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['bill_status', 'Sent'],
        ['billingBalance', '>', 0],
    ])->where(DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date)'), '<', 60)
    ->orderby('created_at','asc')->with(['customers','prod'])->get();
    return view('billing.renewal.due', compact('renewals'));
            
            break;
            
            default:
                # code...
                break;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $guard_object = getActiveGuardType();

        $data['categories'] = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['customers'] = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['products'] = Product::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();
        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        return view('billing.renewal.create', $data);
    }

    
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'duration_type' =>'required',
            'company_email_id' =>'required',
            'company_bank_acc_id' =>'required'
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }
        // dd($request->all());

        if(compareEndStartDate($request->start_date,$request->end_date) == false){
            Alert::error('Invalid End Date', 'Please ensure that the End Date is after the Start Date');
         return back()->withInput();
        }

        DB::beginTransaction();
        try{
            
            $when = now()->addSeconds(5);
            $emails = [];
         $new_renewal = Renewal::createNew($request->all());

              // self::renewalInvoice($new_renewal->id);

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
        $renewal = Renewal::where('id',$id)->whereNull('deleted_at')->first();
       
        if($renewal){
         $renewalPayments = RenewalPayment::where('renewal_id',$renewal->id)->get();
        }
         $renewal_updates = RenewalUpdate::where('renewal_id', $id)->orderBy('created_at','desc')->paginate(10);
       
        return view('billing.renewal.show', compact('renewal','renewalPayments','renewal_updates'));
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
        $data['categories'] = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['customers'] = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['renewal'] = Renewal::where('id',$id)->first();
        $data['products'] = Product::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['subCategory'] = SubCategory::where('id',$data['renewal']->subcategory_id)->first();

        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        
        return view('billing.renewal.edit', $data);
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'renewal_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'sub_category_id' => 'required|numeric',
            'product' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'productPrice' => 'required|numeric',
            'billingAmount' => 'required|numeric',
            'description' => 'required',
            'duration_type' =>'required',
            'company_email_id' =>'required',
            'company_bank_acc_id' =>'required'
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
    
}
