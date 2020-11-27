<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Opportunity;
use App\Customer;
use App\Contact;
use App\Category;
use App\SubCategory;
use App\Product;
use Validator;
use Session;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OpportunityController extends Controller
{
    public function index()
    {
        $userId = getActiveGuardType()->main_acct_id;
        $opportunities = Opportunity::where('main_acct_id', $userId)->get();
        return view('opportunity.index', compact('opportunities'));
    }

    public function create()
    {
        $userId = getActiveGuardType()->main_acct_id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $subCategories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('opportunity.create', compact('customers', 'categories', 'subCategories', 'products'));
    }

    public function store(Request $request)
    {
        $guard_object = getActiveGuardType();
        $input = request()->all();
        //dd($input);
        $rules = [
 
            'opportunity_name' => 'required',
            'account_id' => 'required',
            'stage' => 'required',
            'initiation_date' => 'required',
            'closure_date' => 'required'
        ];
        $message = [
            'opportunity_name.required' => 'Opportunity name is required',
            'account_id.required' => 'Please choose an account',
            'stage.required' => 'Please select a stage',
            'initiation_date.required' => 'Pick an Initiation date',
            'closure.required' => 'Pick a Closure date',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        
            $opportunity = new Opportunity;
            $opportunity->created_by = $guard_object->created_by;
            $opportunity->user_type = $guard_object->user_type;
            $opportunity->main_acct_id = $guard_object->main_acct_id;
            $opportunity->name = $request->opportunity_name;
            $opportunity->owner_id = $request->owner_id;
            $opportunity->account_id = $request->account_id;
            $opportunity->amount = $request->amount;
            $opportunity->probability = $request->probability;
            $opportunity->initiation_date = $request->initiation_date;
            $opportunity->closure_date = $request->closure_date;
            $opportunity->contact_id = $request->contact_id;
            $opportunity->status = $request->status;

            $opportunity->save();
            if($opportunity){
            $product = $request->product_id;
            

            if(isset($request->category_id)) {
                $opportunity->products()->attach($product, [
                    'product_category' => implode($request['category_id']),
                    'product_sub_category' => implode($request->sub_category_id),
                    'product_name' => implode($product),
                    'product_qty' => implode($request->quantity),
                    'product_price' => implode($request->price),
                    // 'main_acct_id' => implode($userId),
                    'main_acct_id' => $guard_object->main_acct_id,
                ]);
            }
            $status = "Opportunity has been saved";
            Alert::success('Opportunity', $status);
            return back();
        }
        
            Alert::error('Add Project', 'This action could not be completed');
            return back()->withInput()->withErrors($validator);
        

    }
    
    /**
     * Method that populates the table according to what is selected .
     */
    public function getOpportunities($id)
    {
        $userId = auth()->user()->id;
        $today = Carbon::now();

        if($id == 1){
            $opportunities = Opportunity::where('main_acct_id', $userId)->get();
            return view('opportunity.all', compact('opportunities'));
        
        } elseif($id == 2) {
            
            $opportunities = Opportunity::where('main_acct_id', $userId)->whereBetween('closure_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])->get();
            return view('opportunity.currentmonth', compact('opportunities'));
        }
         elseif($id == 3) {

            $opportunities = Opportunity::where('main_acct_id', $userId)->whereBetween('closure_date', [$today->copy()->addMonth(1)->startOfMonth(), $today->copy()->endOfMonth()->addMonth(1)])->get();
            return view('opportunity.nextmonth', compact('opportunities'));
        
        } elseif ($id == 4) {

            $user = Auth::user()->name;
            $opportunities = Opportunity::where('main_acct_id', $userId)->where('owner', $user)->get();
            return view('opportunity.myopp', compact('opportunities'));
        
        }elseif ($id == 5) {
            $opportunities = Opportunity::where('main_acct_id', $userId)->where('status', '=', 'Won')->get();
            return view('opportunity.won', compact('opportunities'));
        
        } else {
            $opportunities = Opportunity::where('main_acct_id', $userId)->where('status', '=', 'Lost')->get();
            return view('opportunity.lost', compact('opportunities'));
        }
    }

    /**
     * Shows Information about a particular opportunity
     */
    public function show($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $opportunity = Opportunity::where('main_acct_id', $userId)->where('id', $id)->first();
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $subCategories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        
        return view('opportunity.show', compact('opportunity','customers', 'categories', 'subCategories', 'products'));
    }

    /**
     * Method to modify and update an opportunity's information.
     */
    public function update(Request $request, $id)
    {

        try {
            $opportunity = Opportunity::find($id);
        $opportunity->name = $request->input('opportunity_name');
        $opportunity->owner = $request->input('owner');
        $opportunity->account_id = $request->input('account_id');
        $opportunity->amount = $request->input('amount');
        $opportunity->probability = $request->input('probability');
        $opportunity->stage = $request->input('stage');
        $opportunity->initiation_date = $request->input('initiation_date');
        $opportunity->closure_date = $request->input('closure_date');
        $opportunity->contact = $request->input('contact');

        // dd($opportunity);
        $opportunity->update();

        $product = $request->input('product_id');
        
        if(isset($request->category_id)) {
            $opportunity->products()->attach($product, [
                'product_category' => implode($request->input('category_id')),
                'product_sub_category' => implode($request->input('sub_category_id')),
                'product_name' => implode($product),
                'product_qty' => implode($request->input('quantity')),
                'product_price' => implode($request->input('price')),
            ]);
        }
        $status = "Opportunity has been successfully updated";
        Alert::success('Opportunity', $status);
        return back();
        } catch (\Throwable $th) {
            Alert::error('The process could not be completed');
        }
        
    }
}
