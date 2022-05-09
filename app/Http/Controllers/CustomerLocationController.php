<?php

namespace App\Http\Controllers;

use App\Country;
use App\Services\CustomerLocationService;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Stevebauman\Location\Facades\Location;

class CustomerLocationController extends Controller
{

	public $customerLocationService;

	function __construct(CustomerLocationService $customerLocationService)
	{
        $this->middleware(['auth','mainuserVerified','subuserVerified']);

		$this->customerLocationService = $customerLocationService;
	}

    public function createLocation(Request $request)
    {
    	 $ip = $request->ip();
        if($ip == '127.0.0.1'){
            $ip = '105.112.24.184';
        }

        // get location of user
        $loc = Location::get($ip);
        $location = $loc->countryCode;
        // dd($location);

        // default the country, states and city to these values
        $getCountry = Country::where('sortname', $location)->first();
        // dd($getCountry);
        $states = State::where('country_id', $getCountry->id)->get();
        $countries = Country::all();

        return view('customer.location.create', compact('countries', 'getCountry', 'location','states'));
    	
    }

    public function storeCustomerLocation(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'customer_id' => 'required|numeric',
            'landmark' => 'required',
            'state' => 'required',
            'city' => 'required',
            'street' => 'required',
            'country' => 'required',
            ]);
             // dd($validator);
    	// $validated = $request->validated();
    	// dd($request);

         if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $location = $this->customerLocationService->storeCustomerLocation($request);

        if ($location) {

            $status = "Customer Location successfully created!";
            Alert::success('Create Customer Location', $status);
            return redirect()->back()->withStatus(__( $status ));

            // return redirect()->route('order.lists');
        }

        Alert::error('Create Customer Location', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }
}
