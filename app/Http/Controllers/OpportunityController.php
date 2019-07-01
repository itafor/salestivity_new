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

class OpportunityController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $opportunities = Opportunity::where('main_acct_id', $userId)->get();
        // $client = new Client(['verify' => false]);
        // $res = $client->get('http://localhost:8000/getopportunities/1');
        // $response = $res->getBody()->getContents();
        // $value = (array) json_decode($response);

        // dd($value);

        return view('opportunity.index', compact('opportunities'));
    }

    public function create()
    {
        $userId = auth()->user()->id;
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $subCategories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('opportunity.create', compact('customers', 'categories', 'subCategories', 'products'));
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $input = request()->all();
        // dd($input);
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
        $opportunity->name = $request->opportunity_name;
        $opportunity->owner = $request->owner;
        $opportunity->account_id = $request->account_id;
        $opportunity->amount = $request->amount;
        $opportunity->probability = $request->probability;
        $opportunity->stage = $request->stage;
        $opportunity->initiation_date = $request->initiation_date;
        $opportunity->closure_date = $request->closure_date;
        $opportunity->contact = $request->contact;
        $opportunity->main_acct_id = $userId;
        $opportunity->status = $request->status;

        $opportunity->save();

        $product = $request->product_id;
        

        $opportunity->products()->attach($product, [
            'product_category' => implode($request['category_id']),
            'product_sub_category' => implode($request->sub_category_id),
            'product_name' => implode($product),
            'product_qty' => implode($request->quantity),
            'product_price' => implode($request->price),
            'main_acct_id' => implode($userId),
        ]);
        $status = "Opportunity has been saved";
        Session::flash('status', $status);

        return redirect()->route('opportunity.index');
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
        $userId = auth()->user()->id;
        // dd($userId);
        $opportunity = Opportunity::where('main_acct_id', $userId)->get();
        $customers = Customer::where('main_acct_id', $userId)->get();
        $categories = Category::where('main_acct_id', $userId)->get();
        $subCategories = SubCategory::where('main_acct_id', $userId)->get();
        $products = Product::where('main_acct_id', $userId)->get();
        return view('opportunity.show', compact('opportunity','customers', 'categories', 'subCategories', 'products'));
    }

    /**
     * Method to modify and update an opportunity's information.
     */
    public function update($id)
    {

        $opportunity = new Opportunity;
        $opportunity->name = $request->input('opportunity_name');
        $opportunity->owner = $request->input('owner');
        $opportunity->account_id = $request->input('account_id');
        $opportunity->amount = $request->input('amount');
        $opportunity->probability = $request->input('probability');
        $opportunity->stage = $request->input('stage');
        $opportunity->initiation_date = $request->input('initiation_date');
        $opportunity->closure_date = $request->input('closure_date');
        $opportunity->contact = $request->input('contact');

        $opportunity->save();

        $product = $request->input('product_id');
        

        $opportunity->products()->attach($product, [
            'product_category' => implode($request->input('category_id')),
            'product_sub_category' => implode($request->input('sub_category_id')),
            'product_name' => implode($product),
            'product_qty' => implode($request->input('quantity')),
            'product_price' => implode($request->input('price')),
        ]);
        $status = "Opportunity has been successfully updated";
        Session::flash('status', $status);

        return redirect()->route('opportunity.index');
    }
}
