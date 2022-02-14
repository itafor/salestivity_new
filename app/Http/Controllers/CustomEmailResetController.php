<?php

namespace App\Http\Controllers;

use App\Mail\CustomResetPasswordEmail;
use App\Mail\sendPasswordResetSuccessEmail;
use App\Providers\RouteServiceProvider;
use App\SubUser;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class CustomEmailResetController extends Controller
{
    public function validatePasswordRequest(Request $request)
    {
    	 $validator = Validator::make($request->all(), [
        'email' => 'required|email',
         ]);

    //check if payload is valid before moving on
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());
    }

    	//You can add validation login here
$user = DB::table('users')->where('email', '=', $request->email)->first();
$sub_user = DB::table('sub_users')->where('email', '=', $request->email)
    ->first();
//Check if the user exists
if (!$user && !$sub_user) {
    return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
}


//Create Password Reset Token
$this->createPasswordResetToken($request->email);
//Get the token just created above
$tokenData = DB::table('password_resets')
    ->where('email', $request->email)->first();

    // dd($request->all());

if ($this->sendResetEmail($request->email, $tokenData->token)) {
    return redirect()->back()->with('success', trans('A reset link has been sent to your email address: '.$request->email));
} else {
    return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
}
    }

public function createPasswordResetToken($email)
{
	DB::table('password_resets')->insert([
    'email' => $email,
    'token' => $this->generateRandomString(60),
    'created_at' => Carbon::now()
]);
}

public function generateRandomString($length) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

private function sendResetEmail($email, $token)
{
//Retrieve the user from the database
$user = DB::table('users')->where('email', $email)->first();
$sub_user = DB::table('sub_users')->where('email', '=', $email)->first();
$email = $user ? $user->email : $sub_user->email;

if ($user || $sub_user) {
//Generate, the password reset link. The token generated is embedded in the link
$link = url('/') . '/password/reset/' . $token . '?email=' . urlencode($email);

// dd($link);

    try {
    //Here send the link with CURL with an external email API 
  Mail::to($email)->queue(new CustomResetPasswordEmail($link));
        return true;
    } catch (\Exception $e) {
    	// dd($e->getMessage());
        return false;
    }
}
}

public function resetPassword(Request $request)
{
    //Validate input
// dd($request->all());

    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|confirmed',
        'token' => 'required' ]);

    //check if payload is valid before moving on
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator->errors());

    }

    $password = $request->password;
// Validate the token
    $tokenData = DB::table('password_resets')
    ->where('token', $request->token)->first();

// Redirect the user back to the password reset request form if the token is invalid
    if (!$tokenData){
     return view('auth.passwords.email');
    }

    $user = User::where('email', $tokenData->email)->first();
    $subuser = SubUser::where('email', $tokenData->email)->first();
// Redirect the user back if the email is invalid
    if ($user){
    	$this->updateUserPassword($user, $tokenData, $password);
    	 return redirect()->route('home');
    }elseif($subuser){
    	 $this->updateSubUserPassword($subuser, $tokenData, $password);
    	  return redirect()->route('home');
    }else{
     return redirect()->back()->withErrors(['email' => 'Email not found']);
    }

}

public function updateUserPassword($user, $tokenData, $password)
{
  
  //Hash and update the new password

    $user->password = \Hash::make($password);
    $user->save(); //or $user->save();

    //login the user immediately they change password successfully
    Auth::login($user);

    //Delete the token
    DB::table('password_resets')->where('email', $user->email)
    ->delete();

    //Send Email Reset Success Email
    if ($this->sendSuccessEmail($tokenData->email)) {
        return true;
    } else {
        return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
    }
}

public function updateSubUserPassword($subuser, $tokenData, $password)
{
    $subuser->password = \Hash::make($password);
    $subuser->save(); //or $subuser->save();


 //Delete the token
    DB::table('password_resets')->where('email', $subuser->email)
    ->delete();

    //login the subuser immediately they change password successfully
        if (Auth::guard('sub_user')->attempt(['email' => $subuser->email, 'password' => $password, 'status' => 1])) {
        	
        	//Send Email Reset Success Email
            $this->sendSuccessEmail($tokenData->email);
          
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
        return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
    }
}

public function sendSuccessEmail($email)
{

    try {
    //Here send the link with CURL with an external email API 
  Mail::to($email)->queue(new sendPasswordResetSuccessEmail($email));
        return true;
    } catch (\Exception $e) {
    	// dd($e->getMessage());
        return false;
    }
}

}