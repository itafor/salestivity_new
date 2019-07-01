<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\User;
use App\SalesLocation;
use App\RetailFieldSale;
use Session;
use Validator;
use App\Country;

class RetailFieldSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $sales = RetailFieldSale::where('main_acct_id', $userId)->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = auth()->user()->id;
        $products = Product::where('main_acct_id', $userId)->get();
        $salesPerson = User::where('profile_id', $userId)->get();
        $locations = SalesLocation::where('main_acct_id', $userId)->get();

        return view('sales.create', compact('products', 'salesPerson', 'locations'));
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
        $sale = new RetailFieldSale;
        
        $input = $request->all();
        $rules = [
 
            'product' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total_amount' => 'required',
            'sales_person_id' => 'required',
            'location_id' => 'required',
        ];
        $message = [
            'sales_person_id.required' => 'Sales Person is required',
            'product.required' => 'Product is required',
            'price.required' => 'Price is required',
            'total_amount.required' => 'Amount a product',
            'location_id.required' => 'Location is required',
            'quantity.required' => 'Quantity is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $sale->main_acct_id = $userId;
        $sale->product_id = $request->product;
        $sale->quantity = $request->quantity;
        $sale->price = $request->price;
        $sale->total_amount = $request->total_amount;
        $sale->sales_person_id = $request->sales_person_id;
        $sale->location_id = $request->location_id;
    
        $sale->save();

        $status = "A new Sale has been successfully added ";
        Session::flash('status', $status);

        return redirect()->route('sales.index');


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
        $products = Product::where('main_acct_id', $userId)->get();
        $salesPerson = User::where('profile_id', $userId)->get();
        $locations = SalesLocation::where('main_acct_id', $userId)->get();
        $sale = RetailFieldSale::where('main_acct_id', $userId)->first();
        return view('sales.show', compact('products', 'salesPerson', 'locations', 'sale'));
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
        $sale = RetailFieldSale::where('id', $id)->where('main_acct_id', $userId)->first();
        
        $input = $request->all();
        $rules = [
 
            'product' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total_amount' => 'required',
            'sales_person_id' => 'required',
            'location_id' => 'required',
        ];
        $message = [
            'sales_person_id.required' => 'Sales Person is required',
            'product.required' => 'Product is required',
            'price.required' => 'Price is required',
            'total_amount.required' => 'Amount a product',
            'location_id.required' => 'Location is required',
            'quantity.required' => 'Quantity is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $sale->main_acct_id = $userId;
        $sale->product_id = $request->input('product');
        $sale->quantity = $request->input('quantity');
        $sale->price = $request->input('price');
        $sale->total_amount = $request->input('total_amount');
        $sale->sales_person_id = $request->input('sales_person_id');
        $sale->location_id = $request->input('location_id');
    
        $sale->update();

        $status = "Sale has been successfully updated ";
        Session::flash('status', $status);

        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createLocation()
    {
        $countries = Country::all();
        return view('sales.location.create', compact('countries'));
    }

    public function storeLocation(Request $request)
    {

        $userId = auth()->user()->id;

        $input = $request->all();
        $rules = [
 
            'location' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ];
        $message = [
            'location.required' => 'Location is required',
            'country_id.required' => 'Country is required is required',
            'state_id.required' => 'State is required',
            'city_id.required' => 'City is required',
            'address.required' => 'Address is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        $location = new SalesLocation;

        $location->main_acct_id = $userId;
        $location->location = $request->location;
        $location->country_id = $request->country_id;
        $location->state_id = $request->state_id;
        $location->city_id = $request->city_id;
        $location->address = $request->address;

        $location->save();

        $status = "Location has been successfully added ";
        Session::flash('status', $status);
        return redirect()->route('sales.location.index');
    }


    public function allLocation()
    {
        $userId = auth()->user()->id;
        $locations = SalesLocation::where('main_acct_id', $userId)->get();
        return view('sales.location.index', compact('locations'));
    }

    public function showLocation($id)
    {
        $userId = auth()->user()->id;
        $countries = Country::all();
        $location = SalesLocation::where('main_acct_id', $userId)->where('id', $id)->first();
        return view('sales.location.show', compact('countries', 'location'));
    }

    public function updateLocation(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $input = $request->all();
        $rules = [
 
            'location' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ];
        $message = [
            'location.required' => 'Location is required',
            'country_id.required' => 'Country is required is required',
            'state_id.required' => 'State is required',
            'city_id.required' => 'City is required',
            'address.required' => 'Address is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        $location = SalesLocation::where('main_acct_id', $userId)->where('id', $id)->first();

        $location->main_acct_id = $userId;
        $location->location = $request->input('location');
        $location->country_id = $request->input('country_id');
        $location->state_id = $request->input('state_id');
        $location->city_id = $request->input('city_id');
        $location->address = $request->input('address');

        $location->update();

        $status = "Location has been successfully updated ";
        Session::flash('status', $status);
        return redirect()->route('sales.location.index');
    }
}
