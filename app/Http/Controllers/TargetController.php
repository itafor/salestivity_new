<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;
use App\User;
use App\SubUser;
use App\Product;
use Validator;
use App\Department;
use Session;
use RealRashid\SweetAlert\Facades\Alert;

class TargetController extends Controller
{
    public function index()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $targets = Target::where('main_acct_id', $userId)->get();
        return view('target.index', compact('targets'));
    }
    public function create()
    {
        $userId = \getActiveGuardType()->main_acct_id;
         $departments = Department::where('main_acct_id', $userId)->get()->unique('name')->values()->all();
        $salesPersons = SubUser::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('target.create', compact('salesPersons', 'products','departments'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
       
       $data = $request->all();

            $guard_object = \getActiveGuardType();
            
            $input = $request->all();
            $rules = [
     
                'sales' => 'required',
                'unit_id' => 'required',
                'percentage' => 'required',
                 'qty' => 'required',
                'product_id' => 'required',
                'product_amount' => 'required',
                'achieve_amount' => 'required',
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

            $target_amount = $data['unit_price'] * $data['qty'];
            
            $percentage_amount = ($data['achieve_amount'] / $target_amount) * 100;
            
            $target = new Target;
    
            $target->main_acct_id = $guard_object->main_acct_id;
            $target->user_type = $guard_object->user_type;
            $target->created_by = $guard_object->created_by;
            $target->sales_person_id = $request->sales;
            $target->department_id = $request->department_id;
            $target->unit_id = $request->unit_id;
            $target->amount = $request->product_amount;
            $target->percentage = $percentage_amount;
            $target->manager = $request->manager;
            $target->unit_price = $request->unit_price;
            $target->type = $request->type;
            $target->product_id = $request->product_id;
            $target->status = $request->status;
            $target->qty = $request->qty;
            $target->amt_achieved = $request->achieve_amount;
            
            $target->save();
      if(!$target){
            Alert::error('Build Target', 'The process could not be completed');
            return back()->withInput()->withErrors($validator);
        }


        $status = 'Target has been created';
        Alert::success('Target', $status);
        return redirect()->route('target.index');
    }

    public function getSalesDept($id)
    {

        $userId = \getActiveGuardType()->main_acct_id;
        $user = auth()->user()->department_id;
        $depts = Department::where('id', $user)->where('main_acct_id', $userId)->first();
        return $depts;
    }

    public function manage($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $salesPersons = User::where('profile_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        $target = Target::where('id', $id)->where('main_acct_id', $userId)->first();
        return view('target.manage', compact('salesPersons', 'target', 'products'));
    }

    public function update(Request $request, $id)
    {
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

        try {
            $userId = \getActiveGuardType()->main_acct_id;
            // Find the target 
            $target = Target::find($id);
    
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
            
            $target->update();
    
            $status = 'Target has been successfully updated';
            Alert::success('Target', $status);
            return redirect()->route('target.index');
        } catch (\Throwable $th) {
            Alert::error('Error', 'The Process could not be completed');
            return \back()->withInput()->withErrors($validator);
        }
    }
}
