<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Customer;
use App\Product;
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
        $invoices = Invoice::all();
        // dd($invoices->customer()->customer);

        return view('billing.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
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
        $invoice->status = $request->status;
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
        $invoice = Invoice::find($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('billing.invoice.show', compact('invoice', 'customers', 'products'));
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
        $invoice->delete();

        Session::flash('status', 'The Invoice has been successfully deleted');
        return redirect()->route('billing.invoice.index');
    }
}
