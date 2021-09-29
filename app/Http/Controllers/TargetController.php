<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Department;
use App\Opportunity;
use App\Product;
use App\SubCategory;
use App\SubUser;
use App\Target;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class TargetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified']);
    }

    public function index($sales_person_id, $salesPersons)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $targets = Target::where([
            ['main_acct_id', $userId],
            ['sales_person_id', $sales_person_id]
        ])->get();
        
        return view('target.index', compact('targets', 'salesPersons'));
    }


    public function getTargetsBySalesPerson()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $targetSalesPersons = Target::where('main_acct_id', $userId)->distinct()->get('sales_person_id');
        // dd($targetSalesPersons);
        return view('target.sales-persons', compact('targetSalesPersons'));
    }

    public function create()
    {
        $userId = \getActiveGuardType()->main_acct_id;

        $account_owner = User::find($userId);

        $departments = Department::where('main_acct_id', $userId)->get()->unique('name')->values()->all();
        $salesPersons = SubUser::where('main_acct_id', $userId)->get();

        $products = Product::where('main_acct_id', $userId)->get();
        return view('target.create', compact('salesPersons', 'products', 'departments'));
    }


    public function show($id)
    {
        $data['account_owner'] = User::find(getActiveGuardType()->main_acct_id);
        
        $data['categories'] = Category::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        $data['products'] = Product::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
      ])->get();

          
        $data['target'] = Target::find($id);

        $data['target_amount'] = $data['target']->products->sum('amount');

        $data['sales_person'] = $data['target']->salesPerson;

        $data['salesPersoncloseWonOpportunitiesAmount'] = Opportunity::where([
            ['created_by', $data['sales_person'] ? $data['sales_person']->id : null],
            ['user_type', 'sub_users'],
            ['status', 'Closed Won']
        ])->whereBetween('created_at', [$data['target']->start_date, $data['target']->end_date])->get()->sum('amount');

        if ($data['target_amount'] >= 1) {
            $data['percentage_amount']  = round(($data['salesPersoncloseWonOpportunitiesAmount'] / $data['target_amount']) * 100, 2);
        }


        return view('target.show', $data);
    }



    public function store(Request $request)
    {
        //dd($request->all());
       
        $data = $request->all();
            
        $input = $request->all();

        // dd($input);
        $rules = [
     
                'sales' => 'required',
                'manager' => 'required',
                 'start_date' => 'required',
                'end_date' => 'required',
            ];
        $message = [
                'sales.required' => 'Sales Person is required',
                'manager.required' => 'Line Manager is required',
                'start_date.required' => 'Please select a start date',
                'end_date.required' => 'Please select an end date',
               
                
            ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $target = Target::buildNewTarget($input);
        if (!$target) {
            Alert::error('Build Target', 'The process could not be completed');
            return back()->withInput()->withErrors($validator);
        }


        $status = 'Target has been created';
        Alert::success('Target', $status);
        return redirect()->route('target.show', [$target->id]);
    }

    public function addProductToTarget(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $rules = [
     
                'target_id' => 'required',
                'product_id' => 'required',
                'unit_price' => 'required',
                'quantity' => 'required',
                'amount' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
            ];
        $message = [
                'product_id.required' => 'Product Person is required',
                'unit_price.required' => 'unit price is required',
                'quantity.required' => 'quantity is required',
                'target_id.required' => 'Target id is required',
                'amount.required' => 'Amount is required',
                'category_id.required' => 'Product Category is required',
                'sub_category_id.required' => 'Product sub Category is required',
               
                
            ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $target = Target::find($input['target_id']);

        $target_product = Target::add_target_products($target, $input);
        if (!$target_product) {
            Alert::error('Build Target', 'The process could not be completed');
            return back()->withInput()->withErrors($validator);
        }


        $status = 'Product has been added to target this target';
        Alert::success('Target', $status);
        return redirect()->route('target.show', [$target->id]);
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
            // $target->department_id = $request->input('department_id');
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
            return redirect()->route('target.sales.persons');
        } catch (\Throwable $th) {
            Alert::error('Error', 'The Process could not be completed');
            return \back()->withInput()->withErrors($validator);
        }
    }
}
