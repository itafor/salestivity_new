<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;
use App\User;
use App\Product;
use Validator;
use App\Department;
use Session;

class TargetController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $targets = Target::where('main_acct_id', $userId)->get();
        return view('target.index', compact('targets'));
    }
    public function create()
    {
        $userId = auth()->user()->id;
        $salesPersons = User::where('profile_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('target.create', compact('salesPersons', 'products'));
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        
        $input = $request->all();
        $rules = [
 
            'sales' => 'required',
            'manager' => 'required',
            'type' => 'required',
            'product_id' => 'required',
            'product_amount' => 'required'
        ];
        $message = [
            'sales.required' => 'Sales Person is required',
            'manager.required' => 'Line Manager is required',
            'type.required' => 'Please select a Target type',
            'product_id.required' => 'Select a product',
            'product_amount.required' => 'Amount is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = auth()->user()->department_id;
        $target = new Target;

        $target->main_acct_id = $userId;
        $target->sales_person_id = $request->sales;
        $target->department_id = $request->department_id;
        $target->amount = $request->product_amount;
        $target->percentage = $request->percentage;
        $target->manager = $request->manager;
        $target->unit_price = $request->unit_price;
        $target->type = $request->type;
        $target->product_id = $request->product_id;
        $target->status = $request->status;
        $target->qty = $request->qty;

        $target->save();

        $status = 'Target has been created';
        Session::flash('status', $status);
        return redirect()->route('target.index');
    }

    public function getSalesDept($id)
    {

        $userId = auth()->user()->id;
        $user = auth()->user()->department_id;
        $depts = Department::where('id', $user)->where('main_acct_id', $userId)->first();
        return $depts;
    }

    public function manage($id)
    {
        $userId = auth()->user()->id;
        $salesPersons = User::where('profile_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        $target = Target::where('id', $id)->where('main_acct_id', $userId)->first();
        return view('target.manage', compact('salesPersons', 'target', 'products'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->user()->id;
        
        $input = $request->all();
        $rules = [
 
            'percent_achieved' => 'required',
            'amt_achieved' => 'required',
            // 'type' => 'required',
            // 'product_id' => 'required',
            // 'product_amount' => 'required'
        ];
        $message = [
            'percent_achieved.required' => 'Percentage Achieved is required',
            'amt_achieved.required' => 'Amount Achieved is required',
            // 'type.required' => 'Please select a Target type',
            // 'product_id.required' => 'Select a product',
            // 'product_amount.required' => 'Amount is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = auth()->user()->department_id;
        $target = new Target;

        $target->main_acct_id = $userId;
        $target->sales_person_id = $request->input('sales');
        $target->department_id = $request->input('department_id');
        $target->amount = $request->input('product_amount');
        $target->percentage = $request->input('percent_achieved');
        $target->manager = $request->input('manager');
        $target->unit_price = $request->input('unit_price');
        $target->type = $request->input('type');
        $target->product_id = $request->input('product_id');
        $target->status = $request->input('status');
        $target->qty = $request->input('qty');
        $target->amt_achieved = $request->input('amt_achieved');

        $target->save();

        $status = 'Target has been successfully updated';
        Session::flash('status', $status);
        return redirect()->route('target.index');
    }
}
