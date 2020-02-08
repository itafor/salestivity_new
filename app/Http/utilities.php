<?php

use App\City;
use App\Country;
use App\Industry;
use App\State;
use Carbon\Carbon;



function formatDate($date, $oldFormat, $newFormat)
{
    return Carbon::createFromFormat($oldFormat, $date)->format($newFormat);
}

function compareEndStartDate($start_date,$end_date) {
	date_default_timezone_set("Africa/Lagos");
    $startdate = Carbon::parse(formatDate($start_date, 'd/m/Y', 'Y-m-d'));
    $enddate   =   Carbon::parse(formatDate($end_date, 'd/m/Y', 'Y-m-d'));

    if($enddate < $startdate){
        return false;
    }else{
     return true;
    }
}

function authUserId(){
	return auth()->user()->id;
}

function getIndustries(){
 $industries = Industry::all();
 return $industries;
}

function getCountries(){
 $countries = Country::all();
 return $countries;
}

function getStates(){
 $states = State::all();
 return $states;
}

function getCities(){
 $cities = City::all();
 return $cities;
}