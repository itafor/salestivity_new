<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Renewal;
use App\Customer;
use App\Category;
use App\SubCategory;
use App\Payment;
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
            'customer_id' => 'required',
            'product' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'amount' => 'required|integer',
        ]);

        $renewal->customer_id = $request->customer_id;
        $renewal->product = $request->product;
        $renewal->amount = $request->amount;
        $renewal->start_date = $request->start_date;
        $renewal->end_date = $request->end_date;
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

        $payments = Payment::where('customer_id', $renewal->customer_id)->get();
        return view('billing.renewal.show', compact('renewal', 'customers','products', 'payments'));
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
            'customer_id' => 'required',
            'product' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'period' => 'required',
            // 'amount' => 'required|integer',
        ]);

        $renewal->customer_id = $request->input('customer_id');
        $renewal->product = $request->input('product');
        $renewal->start_date = $request->input('start_date');
        $renewal->end_date = $request->input('end_date');
        // $renewal->amount = $request->input('amount');
        // $renewal->period = $request->input('period');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($id)
    {
        $renewal = Renewal::find($id);
        $customers = Customer::all();
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $products = Product::all();
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
        $this->validate($request, [
            'cost' => 'required',
            // 'category_id' => 'required',
            'product' => 'required',
            'amount' => 'required'
        ]);

        $payment = new Payment;
        $payment->customer_id = $request->customer_id;
        $renewal_id = $request->renewal_id;
        $payment->cost = $request->cost;
        $payment->category_id = $request->category_id;
        $payment->sub_category_id = $request->sub_category_id;
        $payment->amount = $request->amount;
        $payment->discount = $request->discount;
        $payment->status = $request->status;

        $calcDiscount = ($payment->discount/100) * $request->cost;
        $discountCost = $request->cost - $calcDiscount;
        $payment->outstanding = ($request->amount) - ($discountCost);

        $payment->save();
        $product = $request->product;
        
        $payment->renewalsMorph()->sync($renewal_id);
        $payment->product()->sync($product);

        $status = "Payment has been Registerd ";
        Session::flash('status', $status);

        return redirect()->route('billing.renewal.index');
    }
}
