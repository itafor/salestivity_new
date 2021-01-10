<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Invoice;
use App\InvoicePayment;
use App\Mail\InvoicePaid;
use App\Payment;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::where([
            ['created_by', getActiveGuardType()->created_by],
            ['user_type', getActiveGuardType()->user_type]
        ])->orderBy('created_at', 'DESC')->get();

        return view('billing.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('billing.invoice.create', compact('customers', 'products'));
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
            
        $rules = [
            
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try 
            {
            $invoice = new Invoice;
            $invoice->created_by = $guard_object->created_by;
            $invoice->user_type = $guard_object->user_type;
            $invoice->main_acct_id = $guard_object->main_acct_id;
            $invoice->customer = $request->customer;
            $invoice->product = $request->product;
            $invoice->timeline = $request->timeline;
            $invoice->cost = $request->cost;
            $invoice->discount = $request->discount;
            $invoice->status = $request->status;
            $invoice->billingAmount = $request->billingAmount;
            $invoice->billingBalance = $request->billingAmount;
            $invoice->save();

            $status = "New Invoice has been Added ";
            Alert::success('Invoice', $status);
            

            return redirect()->route('billing.invoice.index');
        } catch (\Throwable $th) {
            Alert::error('Invoice', 'This action could not be completed');
            return back()->withInput()->withErrors($validator);
        }
        
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
        // dd($request->all());
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
        $input = $request->all();
        $rules = [
            
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required',
        ];
        $message = [
            'customer.required' => 'Customer name is required',
            'product.required' => 'Please choose a Product',
            'timeline.required' => 'Please pick a timeline',
            'cost.required' => 'Please input cost',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        try {
            $invoice = Invoice::find($id);

        
            $invoice->customer = $request->input('customer');
            $invoice->product = $request->input('product');
            $invoice->timeline = $request->input('timeline');
            $invoice->cost = $request->input('cost');
            $invoice->status = $request->input('status');
            // dd($invoice);
            $invoice->update();
            $status = "Invoice has been been updated ";
            Alert::success('Invoice', $status);
        

            return redirect()->route('billing.invoice.show', $invoice->id);
            
        } catch (\Throwable $th) {
            Alert::error('Invoice', 'The action could not be completed');
            return back()->withInput()->withErrors($validator);
        }
        
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

    /**
     * Store a newly created payment resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function pay(Request $request)
    // {
    //     $userId = \getActiveGuardType()->main_acct_id;
    //     $guard_object = \getActiveGuardType();
    //     $input = $request->all();
    //     $rules = [
            
    //         'cost' => 'required',
    //         'category_id' => 'required',
    //         'product' => 'required',
    //         'amount' => 'required'
    //     ];
    //     $message = [
    //         'cost.required' => 'Please input cost',
    //         'category_id.required' => 'Category is required',
    //         'product.required' => 'Please choose a Product',
    //         'amount.required' => 'Please input an amount',
            
    //     ];
    //     $validator = Validator::make($input, $rules, $message);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator);
    //     }
    

    //     $payment = new Payment;
        
    //     $payment->created_by = $guard_object->created_by;
    //     $payment->user_type = $guard_object->user_type;
    //     $payment->main_acct_id = $userId;
    //     $payment->customer_id = $request->customer_id;
    //     $invoice_id = $request->invoice_id;
    //     $payment->cost = $request->cost;
    //     $payment->category_id = $request->category_id;
    //     $payment->sub_category_id = $request->sub_category_id;
    //     $payment->amount = $request->amount;
    //     $payment->discount = $request->discount;
    //     $payment->status = $request->status;

    //     $calcDiscount = ($payment->discount/100) * $request->cost;
    //     $discountCost = $request->cost - $calcDiscount;
    //     $payment->outstanding = ($request->amount) - ($discountCost);

    //     $payment->save();

    //     $product = $request->product;
        
        
    //     $payment->invoicesMorph()->sync($invoice_id);
    //     $payment->product()->sync($product);

    //     $status = "Payment has been Registerd ";
    //     Alert::success('Payment', $status);

    //     return redirect()->route('billing.invoice.index');
    // }
}
