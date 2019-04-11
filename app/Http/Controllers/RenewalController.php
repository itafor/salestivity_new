<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Renewal;
use App\Customer;
use App\Product;
use Session;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $renewals = Renewal::all();
        return view('billing.renewal.index', compact('renewals'));
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
        $renewal = new Renewal;

        $this->validate($request, [
            'customer' => 'required',
            'product' => 'required',
            'period' => 'required',
            'amount' => 'required|integer',
        ]);

        $renewal->customer = $request->customer;
        $renewal->product = $request->product;
        $renewal->amount = $request->amount;
        $renewal->period = $request->period;
        $renewal->save();


        $status = "Renewal has been Added ";
        Session::flash('status', $status);
        

        return redirect()->route('billing.renewal.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $renewal = Renewal::find($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('billing.renewal.show', compact('renewal', 'customers','products'));
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
        $renewal = Renewal::find($id);

        $this->validate($request, [
            'customer' => 'required',
            'product' => 'required',
            'period' => 'required',
            'amount' => 'required|integer',
        ]);

        $renewal->customer = $request->input('customer');
        $renewal->product = $request->input('product');
        $renewal->amount = $request->input('amount');
        $renewal->period = $request->input('period');
        $renewal->save();


        $status = "Renewal has been Updated ";
        Session::flash('status', $status);
        

        return redirect()->route('billing.renewal.show', $renewal->id);
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
        $renewal->delete();

        Session::flash('status', 'The renewal has been successfully deleted');
        return redirect()->route('billing.renewal.index');
    }
}
