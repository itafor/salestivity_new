<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Stevebauman\Location\Facades\Location;
use Validator;

class LocationController extends Controller
{

	public function fetchCities(Request $request){

            $cities = [];
  City::with(['state'])->chunk(100, function($citiesValue) use (&$cities) {

    foreach ($citiesValue as $city) {
        $cities[] = $city;
    }
 });

// dd($cities);
        return view('location.city.index', compact('cities'));

	}

public function createCity(Request $request){
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

        return view('location.city.create', compact('countries', 'getCountry', 'location', 'states'));

	}

    public function AddCity(Request $request){
    	//dd($request->all());
    	$data = $request->all();
    	$validate = Validator::make($request->all(), [
    		'state' => 'required',
    		'name' => 'required'
    	]);

    $newCity =	self::createNewCity($request->all(), $request->state);
  
    if($newCity){
    	 $status = "City has been successfully added";
		Alert::success('status', $status);
		return back();
    }else{
    	 $status = "Something went wrong";
		Alert::warning('status', $status);
		return back();
    }

    }

    public static function createNewCity($data, $stateId)
  {
  	if(isset($data['cities'])){
      foreach ($data['cities'] as $key => $city) {
      $newCity = new City();
    		$newCity->name = implode(', ', $city);
    		$newCity->state_id = $stateId;
    	$newCity->save();
      }

        return $newCity;
    }
}
}
