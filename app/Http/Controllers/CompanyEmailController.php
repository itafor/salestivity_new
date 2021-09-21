<?php

namespace App\Http\Controllers;

use App\CompanyEmail;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class CompanyEmailController extends Controller
{

	 public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except('homepage');
    }
    
     public function index()
    {
        $data['user'] = User::where('id', getActiveGuardType()->main_acct_id)->first();
       
        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
      
            
        return view('settings.companyEmails', $data);
    }
     public function addCompanyEmail(Request $request)
    {
        $data = $request->all();

       // dd($data);
            if(!isset($data['company_email'])){
                $status = "Please enter your company email!!";
        Alert::warning('Company Email', $status);
        return back();
            }
        
            CompanyEmail::create([
                    "main_acct_id" => getActiveGuardType()->main_acct_id,
                    "email" => $data['company_email'],
                    "driver"        =>      $data['driver'],
                    "host"          =>      $data['hostName'],
                    "port"          =>      $data['port'],
                    "encryption"    =>      $data['encryption'],
                    "user_name"     =>      $data['userName'],
                    "password"      =>      $data['password'],
                    "sender_name"   =>      $data['senderName'],
            ]);
             $status = "Company Email added!!";
        Alert::success('Company Email', $status);
        
       return redirect()->route('company.email.index');
    }

public function updateCompanyEmail(Request $request)
    {
        $data = $request->all();
            if(!isset($data['company_email'])){
                $status = "Please enter your company email!!";
        Alert::warning('Company Email', $status);
        return back();
            }
        
            $compemail = CompanyEmail::where([
            ['id', $data['company_email_id']],
            ])->first();

            if($compemail){
             $compemail->email = $data['company_email'];
            $compemail->driver      =      $data['driver'];
            $compemail->host          =      $data['hostName'];
            $compemail->port          =      $data['port'];
            $compemail->encryption    =      $data['encryption'];
            $compemail->user_name     =      $data['userName'];
            $compemail->password    =      $data['password'];
            $compemail->sender_name  =      $data['senderName'];

            $compemail->save();
            $status = "Company email updated!!";
        Alert::success('Company Name', $status);
            }
        
       return redirect()->route('company.email.index')->with('success','Company email updated!!');
    }
}
