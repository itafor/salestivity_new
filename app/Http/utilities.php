<?php

use App\Category;
use App\City;
use App\CompanyAccountDetail;
use App\CompanyDetail;
use App\CompanyEmail;
use App\Contact;
use App\Country;
use App\Customer;
use App\Industry;
use App\State;
use App\SubCategory;
use App\SubUser;
use App\User;
use Carbon\Carbon;
use JD\Cloudder\Facades\Cloudder;



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

function productCategories(){
 $categories = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
 if($categories){
 return $categories;
 }
}

function productSubCategories(){
 $sub_categories = SubCategory::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
 if($sub_categories){
 return $sub_categories;
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

function authUser()
{
   return auth()->user();
}

function customerContacts($customerId)
{
    return Contact::where([
        ['main_acct_id',getActiveGuardType()->main_acct_id],
        ['customer_id',$customerId]
    ])->get();
}

function allCustomers()
{
   return Customer::all();
}

function mySubUsers()
{
    return SubUser::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
}

function addMainAccountOwnerToSubUser()
{
    if (getActiveGuardType()->user_type == 'users') {
   
    $emailExist = SubUser::where('email',authUser()->email)->first();
    if(!$emailExist){
    $user = new SubUser;
    $user->name = authUser()->name;
    $user->last_name = authUser()->last_name;
    $user->email = authUser()->email;
    $user->main_acct_id = authUser()->id;
    $user->password = Hash::make('password1xxx');
    $user->save();
    }
}
   
}

function updatePrimaryUserLevel()
{
    if (getActiveGuardType()->user_type == 'users') {
   
    $primary_user = SubUser::where('email',authUser()->email)->first();
    if($primary_user && $primary_user->level == null){

    $primary_user->level = 1;
    $primary_user->password = Hash::make('password1xxx');

    $primary_user->save();
    }
}
   
}

function subuser($email)
{
    return SubUser::where('email', $email)->first();
}

function users_that_reports_to_main_user()
{
    $guard_object = getActiveGuardType();
    if($guard_object->user_type == 'users'){
        $get_main_user_from_subuser = SubUser::where('email',authUser()->email)->first();

       return $get_main_user_from_subuser->users_that_report_tome;
    }

    return authUser()->users_that_report_tome;
}

function uploadImage($image)
{
    if(isset($image))
    {
        if($image->isValid()) 
        {
            $filename = $name = 'Salestivity_'.$image->getClientOriginalName();
            $filename = str_replace(' ','_', $filename);
            $trans = array(
                ".png" => "", 
                ".PNG" => "",
                ".JPG" => "",
                ".jpg" => "",
                ".jpeg" => "",
                ".JPEG" => "",
                ".bmp" => "",
                ".pdf" => "",
            );
            $filename = strtr($filename,$trans);
            Cloudder::upload($image->getPathname(), $filename);
            $response = Cloudder::getResult();
            $path = $response['secure_url'];
            // $image->move(public_path("uploads"), $image->getClientOriginalName());
        }
    }
    return $path;
}

function company_details_alerts(){
      $data['user'] = User::where([
        ['id', getActiveGuardType()->main_acct_id],
        ['company_logo_url', '!=', null]
    ])->first();
        $data['companyDetail'] = CompanyDetail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['name', '!=', null]
        ])->first();
        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
  if($data['user'] == '' || $data['companyDetail'] == '' || $data['companyEmails'] == '' || $data['companyBankDetails'] == ''){
        return  'show alert';
  }
}