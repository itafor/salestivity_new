<?php

use App\City;
use App\Country;
use App\Industry;
use App\State;
use Carbon\Carbon;
use App\User;
use App\SubUser;



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
 if($cities){
 return $cities;
 }
}

/**
 * This function gets the current logged in user guard type
 */
function getActiveGuardType()
{
    // get the user guard type
    if(auth()->guard('sub_user')->check()) {
        // get the sub_user's main_acct_id
        $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
        $created_by = auth()->guard('sub_user')->user()->id;
        $userType = 'sub_users';

        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];
        return $objectResult;
    }
    if(auth()->user()) {
        $main_acct_id = auth()->user()->id;
        $created_by = auth()->user()->id;
        $userType = 'users';
        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];

        return $objectResult;
    }

    if(auth()->guard('admin')->check()) {
        // get the admin's main_acct_id
        $main_acct_id = auth()->guard('admin')->user()->main_acct_id;
        $created_by = auth()->guard('admin')->user()->id;
        $userType = 'admins';

        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];
        return $objectResult;
    }
}

/**
 * Get created by name
 */
function getCreatedByDetails($userType, $userId)
{
    if($userType === 'users'){
        $user = User::find($userId);
        // dd(gettype($user));
        return $user;
    }
    if($userType === 'sub_users'){
        $user = SubUser::find($userId);
        return $user;
    }
    
}

function convertNumberToWord($number)
{
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
return $f->format($number);
}