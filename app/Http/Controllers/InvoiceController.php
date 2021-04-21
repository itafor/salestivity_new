<?php

namespace App\Http\Controllers;

use App\Category;
use App\CompanyAccountDetail;
use App\CompanyEmail;
use App\Customer;
use App\Invoice;
use App\InvoicePayment;
use App\Mail\InvoicePaid;
use App\Mail\SendInvoice;
use App\Payment;
use App\Product;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;
use PDF;

class InvoiceController extends Controller
{
   public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except(['homepage','verifySubuserEmail']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['invoices'] = Invoice::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->orderBy('created_at', 'DESC')->paginate(10);


        return view('billing.invoice.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = \getActiveGuardType()->main_acct_id;

        $data['customers'] = Customer::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();

       
        $data['categories'] = Category::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

         $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
         
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

        return view('billing.invoice.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guard_object = \getActiveGuardType();
        $input = $request->all();
            // dd($input);
        $rules = [
            
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'company_email_id' => 'required',
            'company_bank_acc_id' => 'required',
            'due_date' => 'required',


        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            'category_id.required' => 'Product category is required',
            'sub_category_id.required' => 'Product subcategory is required',
            'company_email_id.required' => 'company email  is required',
            'company_bank_acc_id.required' => 'company bank account is required',
            'due_date.required' => 'Due date is required',

            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

            $invoice = new Invoice;
            $invoice->created_by = $guard_object->created_by;
            $invoice->user_type = $guard_object->user_type;
            $invoice->main_acct_id = $guard_object->main_acct_id;
            $invoice->customer = $request->customer;
            $invoice->category_id = $request->category_id;
            $invoice->subcategory_id = $request->sub_category_id;
            $invoice->product_id = $request->product;
            $invoice->timeline = $request->timeline;
            $invoice->cost = $request->cost;
            $invoice->discount = $request->discount;
            $invoice->status = 'Pending';
            $invoice->billingAmount = $request->billingAmount;
            $invoice->billingBalance = $request->billingAmount;
            $invoice->company_email_id = $request->company_email_id;
            $invoice->company_bank_acc_id = $request->company_bank_acc_id;
            $invoice->due_date = Carbon::parse(formatDate($request->due_date, 'd/m/Y', 'Y-m-d'));
            $invoice->invoice_number = 'DW'.mt_rand(1000, 9999);
            $invoice->save();

            if($invoice){

              $toEmail = $invoice->customers->email;

            Mail::to($toEmail)->send(new SendInvoice($invoice));

                  $status = "New Invoice has been Added ";
            Alert::success('Invoice', $status);

            return redirect()->route('billing.invoice.index');
            }

            Alert::error('Invoice', 'This action could not be completed');
            return back()->withInput()->withErrors($validator);
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
// dd($invoice->invoicePayment);
        // $payments = Payment::where('customer_id', $invoice->customer)->where('status', '!=', 'Renewal')->get();
        
        
        return view('billing.invoice.show', compact('invoice'));
      
    }

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
            'invoice_id' => 'required|numeric',
            'payment_date' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }

        DB::beginTransaction();
        try{
         $paid_invoice =  InvoicePayment::createNew($request->all());
             $toEmail = $paid_invoice->customer->email;

            Mail::to($toEmail)->send(new InvoicePaid($paid_invoice));
      
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            
            Alert::error('Invoice Payment', 'An attempt to record invoice payment failed');
         return back()->withInput();
            
        }
        
        Alert::success('invoice Payment', 'Invoice payment recorded successfully');
        return redirect()->route('billing.invoice.show',$request->invoice_id);
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $sub_categories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('billing.invoice.manage', compact('invoice', 'customers', 'products', 'categories', 'sub_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['invoice'] = Invoice::find($id);

          $data['categories'] = Category::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

      $data['customers'] = Customer::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();

        return view('billing.invoice.edit',$data);
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
        $input = $request->all();
       // dd($input);
              $rules = [
            'invoice_id' => 'required',
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            'category_id.required' => 'Product category is required',
            'sub_category_id.required' => 'Product subcategory is required',
            'invoice_id.required' => 'Invoice ID is required',
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


            $invoice = Invoice::find($input['invoice_id']);
            $invoice->customer = $request->input('customer');
            $invoice->category_id = $request->category_id;
            $invoice->subcategory_id = $request->sub_category_id;
            $invoice->product_id = $request->input('product');
            $invoice->timeline = $request->input('timeline');
            $invoice->cost = $request->input('cost');
            $invoice->status = $request->input('status');
            $invoice->update();
            if($invoice){
            $status = "Invoice has been been updated ";
            Alert::success('Invoice', $status);

            return redirect()->route('billing.invoice.show', $invoice->id);
            }
        
            Alert::error('Invoice', 'The action could not be completed');
            return back()->withInput()->withErrors($validator);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        // $payment = Payment::where
        $invoice->delete();

        Session::flash('status', 'The Invoice has been successfully deleted');
        return redirect()->route('billing.invoice.index');
    }

   public function downloadInvoicePayment($invoiceId){
    
      $invoice = Invoice::find($invoiceId);
      
      $pdf = PDF::loadView('emails.sendinvoice', [
            'invoice' => $invoice, 
        ]);

      return $pdf->download('invoicePayment.pdf');
   }

   public function resendInvoicePayment($invoiceId){

      $invoice = Invoice::find($invoiceId);

      $toEmail = $invoice->customers->email;

        $invoiceResent =  Mail::to($toEmail)->send(new SendInvoice($invoice));

            $status = "Invoice has been resent successfully";
            Alert::success('Invoice Resent', $status);
            return back();
          
   }
}
