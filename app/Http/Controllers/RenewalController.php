<?php

namespace App\Http\Controllers;

use App\BillingAgent;
use App\CarbonCopyEmail;
use App\Category;
use App\CompanyAccountDetail;
use App\CompanyEmail;
use App\Contact;
use App\CurrencySymbol;
use App\Customer;
use App\Http\Controllers\CronJobController;
use App\Http\Traits\RecurringBillStatus;
use App\Http\Traits\RenewalInvoiceTrait;
use App\Http\Traits\RenewalPaymentTrait;
use App\Jobs\SendRenewalPaymentNotification;
use App\MailFromName;
use App\Mail\ConfirmRecurringInvoiceRecceipt;
use App\Mail\RenewalPaid;
use App\Notifications\RenewalCreated;
use App\Payment;
use App\Product;
use App\Renewal;
use App\RenewalPayment;
use App\RenewalUpdate;
use App\ReplyToEmail;
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
        $data['renewals'] = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', '!=', 'Paid'],
        ])->orderBy('end_date', 'asc')->with(['customers','prod'])->get();
        // dd($data['renewals']);
        return view('billing.renewal.index', $data);
    }

    public function getBillingRenewals($id)
    {
        switch ($id) {
            case 'all':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('end_date', 'asc')->with(['customers','prod'])->get();

        return view('billing.renewal.all', compact('renewals'));

                break;
     case 'Pending':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Pending']
        ])->orderby('created_at', 'asc')->with(['customers','prod'])->get();
        return view('billing.renewal.pending', compact('renewals'));
                
                break;
     case 'paid':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Paid']
        ])->orderby('created_at', 'asc')->with(['customers','prod'])->get();
        return view('billing.renewal.paid', compact('renewals'));
                
                break;
       case 'partly_paid':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', 'Partly paid']
        ])->orderby('created_at', 'asc')->with(['customers','prod'])->get();
        return view('billing.renewal.partly_paid', compact('renewals'));
                
                break;
       case 'outstanding':
                $renewals = Renewal::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['status', '!=', 'Paid'],
        ])->orderby('created_at', 'asc')->with(['customers','prod'])->get();
        return view('billing.renewal.outstanding', compact('renewals'));
                
                break;
     case 'due':
            $renewals = Renewal::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['billingBalance', '>', 0],
    ])->where(DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),renewals.end_date)'), '<', 60)
    ->orderby('created_at', 'asc')->with(['customers','prod'])->get();
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
         $data['currencies'] = CurrencySymbol::all();
        $data['categories'] = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['customers'] = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['products'] = Product::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();
        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['mail_from_name'] = User::where([
                ['id', getActiveGuardType()->main_acct_id],
        ])->first();

         $data['reply_to_emails'] = ReplyToEmail::where([
                ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

       $data['cc_emails'] = CarbonCopyEmail::where([
                ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();


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
            // 'company_email_id' =>'required',
            'company_bank_acc_id' =>'required',
            'currency_id' =>'required',
            'reply_to_email_id' =>'required',
            // 'mail_from_name_id' =>'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in all required fields');
            return back()->withInput();
        }
        // dd($request->all());

        if (compareEndStartDate($request->start_date, $request->end_date) == false) {
            Alert::error('Invalid End Date', 'Please ensure that the End Date is after the Start Date');
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            $when = now()->addSeconds(5);
            $emails = [];

            $new_renewal = Renewal::createNew($request->all());

            // self::renewalInvoice($new_renewal->id);

            DB::commit();
        } catch (Exception $e) {
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
    public function show($id, $status, $navStatus)
    {
        $renewalPayments='';
        $renewal = Renewal::where([
            ['id', $id],
            ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->first();
        // dd($renewal);

        $maxId = 0;
        $minId = 0;
        $currentId = $id;
        
        if ($renewal) {
            $renewalPayments = RenewalPayment::where('renewal_id', $renewal->id)->get();
        }
        $renewal_updates = RenewalUpdate::where('renewal_id', $id)->orderBy('created_at', 'desc')->paginate(10);
       
        return view('billing.renewal.show', compact('renewal', 'renewalPayments', 'renewal_updates', 'maxId', 'minId', 'currentId'));
    }

    /**
     * Navigate from one renewal to another
     * @param mixed $id
     * @param mixed $status
     * @param mixed $navStatus
     *
      * @return \Illuminate\Http\Response
     */
    public function navigateRenewals($id, $status, $navStatus)
    {
        $renewalPayments='';

        $maxId = 0;
        $minId = 0;
        $currentId = $id;
        if ($status == "partly_paid" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingRenewalMaxId('Partly paid');
            $renewal = Renewal::where([
        $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id] ,
        ['status', 'Partly paid'],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'asc')->with(['customers','prod'])->first();
        } elseif ($status == "Pending" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingRenewalMaxId('Pending');
            $renewal = Renewal::where([
        $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id] ,
        ['status', 'Pending'],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'asc')->with(['customers','prod'])->first();
        } elseif ($status == "paid" && $navStatus == "next") {
            $maxId = $this->getPaidPartlyPaidPendingRenewalMaxId('paid');
            $renewal = Renewal::where([
        $maxId == $id ? ['id', '>=', $id] : ['id', '>', $id] ,
            ['status', 'Paid'],

        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'asc')->with(['customers','prod'])->first();
        } elseif ($status == "partly_paid" && $navStatus == "previous") {
            $minId =  $this->getPaidPartlyPaidPendingRenewalMinId('Partly paid');
            $renewal = Renewal::where([
         $minId == $id ? ['id', '<=', $id] : ['id', '<', $id] ,
            ['status', 'Partly paid'],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'desc')->with(['customers','prod'])->first();
        } elseif ($status == "Pending" && $navStatus == "previous") {
            $minId =  $this->getPaidPartlyPaidPendingRenewalMinId('Pending');
            $renewal = Renewal::where([
         $minId == $id ? ['id', '<=', $id] : ['id', '<', $id] ,
            ['status', 'Pending'],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'desc')->with(['customers','prod'])->first();
        } elseif ($status == "paid" && $navStatus == "previous") {
            $minId =  $this->getPaidPartlyPaidPendingRenewalMinId('Paid');
            $renewal = Renewal::where([
         $minId == $id ? ['id', '<=', $id] : ['id', '<', $id] ,
            ['status', 'Paid'],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('id', 'desc')->with(['customers','prod'])->first();
        }

        if ($renewal) {
            $renewalPayments = RenewalPayment::where('renewal_id', $renewal->id)->get();
        }
        $renewal_updates = RenewalUpdate::where('renewal_id', $id)->orderBy('created_at', 'desc')->paginate(10);
       
        return view('billing.renewal.show', compact('renewal', 'renewalPayments', 'renewal_updates', 'maxId', 'minId', 'currentId'));
    }


    /**
     * Get paid, partly paid and pending renewal with the highest id
     * @param mixed $status
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaidPartlyPaidPendingRenewalMaxId($status)
    {
        return Renewal::where([
            ['status', $status],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->max('id');
    }

    /**
     * Get paid, partly paid and pending renewal with the lowest id
     * @param mixed $status
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaidPartlyPaidPendingRenewalMinId($status)
    {
        return Renewal::where([
            ['status', $status],
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->min('id');
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
          $data['currencies'] = CurrencySymbol::all();
        $data['categories'] = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['customers'] = Customer::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['renewal'] = Renewal::where('id', $id)->first();
        $data['products'] = Product::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        $data['subCategory'] = SubCategory::where('id', $data['renewal']->subcategory_id)->first();

        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        
        $data['product'] = $data['renewal']->prod;

        $data['mail_from_name'] = User::where([
                ['id', getActiveGuardType()->main_acct_id],
        ])->first();

         $data['reply_to_emails'] = ReplyToEmail::where([
                ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

          $data['cc_emails'] = CarbonCopyEmail::where([
                ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

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
        // dd($request->all());
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
            // 'company_email_id' =>'required',
            'company_bank_acc_id' =>'required',
            'reply_to_email_id' =>'required',
            // 'mail_from_name_id' =>'required',
            'cc_email_id' =>'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        if (compareEndStartDate($request->start_date, $request->end_date) == false) {
            Alert::error('Invalid End Date', 'End Date cannot be less than start date');
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            Renewal::updateRenewal($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            
            Alert::error('Renewal Update Failed', 'An attempt to edit the selected renewal failed');
            return back()->withInput();
        }
        
        Alert::success('Renewal Update successful', 'Renewal updated successfully');
        return back();//redirect()->route('billing.renewal.show', $request->renewal_id);
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
