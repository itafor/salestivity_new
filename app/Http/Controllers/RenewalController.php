<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Payment;
use App\Product;
use App\Renewal;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
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
        $renewals = Renewal::where('main_acct_id', $userId)->get();
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
            'discount' => 'required|numeric',
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
            Renewal::createNew($request->all());
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id;
        $renewal = Renewal::where('id',$id)->where('main_acct_id', $userId)->first();
        $customers = Customer::all();
        $products = Product::all();

        $payments = Payment::where('customer_id', $renewal->customer_id)->where('status', 'Renewal')->where('main_acct_id', $userId)->get();
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
        $userId = auth()->user()->id;
        $renewal = Renewal::where('id', $id)->where('main_acct_id', $userId);

        $this->validate($request, [
            'customer_id' => 'required',
            'product' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'period' => 'required',
            // 'amount' => 'required|integer',
        ]);

        $renewal->main_acct_id = $userId;
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
        $userId = auth()->user()->id;
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
        $payment->main_acct_id = $userId;
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
