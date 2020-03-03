<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;
use App\Customer;
use App\Product;
use App\Category;
use App\SubCategory;
use App\Payment;
use Session;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $invoices = Invoice::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        $customers = Customer::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        // dd($invoices->customer()->customer);

        return view('billing.invoice.index', compact('invoices', 'customers'));
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
        $userId = auth()->user()->id;
        $invoice = new Invoice;

        $this->validate($request, [
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required|integer',
        ]);
        $invoice->customer = $request->customer;
        $invoice->product = $request->product;
        $invoice->timeline = $request->timeline;
        $invoice->cost = $request->cost;
        $invoice->discount = $request->discount;
        $invoice->status = $request->status;
        $invoice->main_acct_id = $userId;
        $invoice->save();


        $status = "New Invoice has been Added ";
        Session::flash('status', $status);
        

        return redirect()->route('billing.invoice.index');
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
        $invoice = Invoice::find($id);
        $customers = Customer::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();

        $payments = Payment::where('customer_id', $invoice->customer)->where('status', '!=', 'Renewal')->get();
        
        
        return view('billing.invoice.show', compact('invoice', 'customers', 'products', 'payments'));
        // dd($payment_type->invoicesMorph);

        // $arr1 = [];
        // foreach($payment_type->invoicesMorph as $invoice){
        //     $arr1[] = $invoice->customers->name;
        // };
        // dd($arr1);

        // $arr = [];
        // $lost = [];
        // foreach($payments as $payment){
        //     $list[] = $payment->product;
        //     foreach($payment->product as $product) {
        //         // dd($payment->product);
        //     $arr[] = $product->name;
        // };
    // };
    // dd($list);
        // dd($arr);
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
        $invoice = new Invoice;

        $this->validate($request, [
            'customer' => 'required',
            'product' => 'required',
            'timeline' => 'required',
            'cost' => 'required|integer',
        ]);
        $invoice->customer = $request->input('customer');
        $invoice->product = $request->input('product');
        $invoice->timeline = $request->input('timeline');
        $invoice->cost = $request->input('cost');
        $invoice->status = $request->input('status');
        // dd($invoice);
        $invoice->save();


        $status = "Invoice has been been updated ";
        Session::flash('status', $status);
        

        return redirect()->route('billing.invoice.show', $invoice->id);
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
    public function pay(Request $request)
    {
        $userId = auth()->user()->id;
        $this->validate($request, [
            'cost' => 'required',
            'category_id' => 'required',
            'product' => 'required',
            'amount' => 'required'
        ]);

        $payment = new Payment;
        $payment->customer_id = $request->customer_id;
        $invoice_id = $request->invoice_id;
        $payment->cost = $request->cost;
        $payment->category_id = $request->category_id;
        $payment->sub_category_id = $request->sub_category_id;
        $payment->amount = $request->amount;
        $payment->discount = $request->discount;
        $payment->status = $request->status;
        $payment->main_acct_id = $userId;

        

        $calcDiscount = ($payment->discount/100) * $request->cost;
        $discountCost = $request->cost - $calcDiscount;
        $payment->outstanding = ($request->amount) - ($discountCost);

        $payment->save();
        $product = $request->product;
        
        
        $payment->invoicesMorph()->sync($invoice_id);
        $payment->product()->sync($product);

        $status = "Payment has been Registerd ";
        Session::flash('status', $status);

        return redirect()->route('billing.invoice.index');
    }
}
