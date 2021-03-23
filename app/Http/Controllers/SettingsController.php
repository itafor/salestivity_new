<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
     public function index()
    {
        $data['user'] = User::where('id', getActiveGuardType()->main_acct_id)->first();

        return view('settings.index', $data);
    }

    public function uploadCompanyLogo(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
        		'company_logo_url' => 'required',
        ]);


        $user = User::find(getActiveGuardType()->main_acct_id);
        if($user){
        	$user->company_logo_url = isset($data['company_logo_url']) ? uploadImage($data['company_logo_url']) : '';
        	$user->save();
        }
       return redirect()->route('settings.index')->with('success','Company logo uploaded');
    }

}
