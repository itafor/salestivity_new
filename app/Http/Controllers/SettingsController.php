<?php

namespace App\Http\Controllers;

use App\CompanyAccountDetail;
use App\CompanyDetail;
use App\CompanyEmail;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class SettingsController extends Controller
{
     public function index()
    {
        $data['user'] = User::where('id', getActiveGuardType()->main_acct_id)->first();
        $data['companyDetail'] = CompanyDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->first();
        $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
        $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
            
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
       return redirect()->route('company_details.index')->with('success','Company logo uploaded');
    }

        public function updateCompanyName(Request $request)
    {
        $data = $request->all();

       
            if(!isset($data['company_name'])){
                $status = "Please enter your company name!!";
        Alert::warning('Company Name', $status);
        return back();
            }
           

        $user = CompanyDetail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['id', $data['company_detail_id']],
            ])->first();
        if($user){
            $user->name = isset($data['company_name']) ? $data['company_name'] : '';
            $user->save();
             $status = "Company name updated!!";
        Alert::success('Company Name', $status);
        }else{
            CompanyDetail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'name' => $data['company_name'],
            ]);
             $status = "Company name updated!!";
        Alert::success('Company Name', $status);
        }
       return redirect()->route('company_details.index')->with('success','Company name updated');
    }

         public function addCompanyEmail(Request $request)
    {
        $data = $request->all();

       
            if(!isset($data['company_email'])){
                $status = "Please enter your company email!!";
        Alert::warning('Company Email', $status);
        return back();
            }
        
            CompanyEmail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'email' => $data['company_email'],
            ]);
             $status = "Company Email added!!";
        Alert::success('Company Email', $status);
        
       return redirect()->route('company_details.index');
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
            $compemail->save();
            $status = "Company email updated!!";
        Alert::success('Company Name', $status);
            }
        
       return redirect()->route('company_details.index')->with('success','Company email updated!!');
    }

         public function addCompanyBankAccount(Request $request)
    {
        $data = $request->all();
        
            CompanyAccountDetail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'bank_name' => $data['bank_name'],
                    'account_name' => $data['account_name'],
                    'account_number' => $data['account_number'],
            ]);
             $status = "Company Bank Account detail added!!";
        Alert::success('Company Bank Account Detail', $status);
        
       return redirect()->route('company_details.index');
    }

    public function updateCompanyBankDetail(Request $request)
    {
        $data = $request->all();
        
            $bank_account = CompanyAccountDetail::where([
            ['id', $data['company_bank_account_id']],
            ])->first();

            if($bank_account){
             $bank_account->bank_name = $data['bank_name'];
             $bank_account->account_name = $data['account_name'];
             $bank_account->account_number = $data['account_number'];
            $bank_account->save();
            $status = "Company bank account detail updated!!";
               Alert::success('Company Bank Account', $status);
            }
        
       return redirect()->route('company_details.index');
    }

}
