<?php

namespace App\Http\Controllers;

use App\CompanyAccountDetail;
use App\CompanyDetail;
use App\CompanyEmail;
use App\CurrencySymbol;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class SettingsController extends Controller
{
     public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except('homepage');
    }
    
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


    public function updateMailFromName(Request $request)
    {
        $data = $request->all();
        // dd($data);
            if(!isset($data['mail_from_name'])){
                $status = "Please enter your Mail From Name!!";
        Alert::warning('Mail From Name', $status);
        return back();
            }
           

        $user = CompanyDetail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['id', $data['company_detail_id']],
            ])->first();
        if($user){
            $user->mail_from_name = isset($data['mail_from_name']) ? $data['mail_from_name'] : '';
            $user->save();
             $status = "Company mail from name updated!!";
        Alert::success('Mail From Name', $status);
        }else{
            CompanyDetail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'mail_from_name' => $data['mail_from_name'],
            ]);
             $status = "Company name From updated!!";
        Alert::success('Company Mail From Name', $status);
        }
       return redirect()->route('company_details.index')->with('success','Company mail from name updated');
    }


    public function updateReplyToEmailAddress(Request $request)
    {
        $data = $request->all();

         $validator = Validator::make($data, [
                'reply_to_email' => ['required', 'string', 'email', 'max:255'],
        ]);
         if($validator->fails()){
                 Alert::warning('Required Fields', 'Please enter a valid email address');
            return back()->withInput();
         }
           
            if(!isset($data['reply_to_email'])){
                $status = "Please enter your Mail From Name!!";
        Alert::warning('Reply To Email', $status);
        return back();
            }
           

        $user = CompanyDetail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['id', $data['company_detail_id']],
            ])->first();
        if($user){
            $user->reply_to_email = isset($data['reply_to_email']) ? $data['reply_to_email'] : '';
            $user->save();
             $status = "Company Reply To Email updated!!";
        Alert::success('Mail From Name', $status);
        }else{
            CompanyDetail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'reply_to_email' => $data['reply_to_email'],
            ]);
             $status = "Company Reply To Email updated!!";
        Alert::success('Company Reply to Email', $status);
        }
       return redirect()->route('company_details.index')->with('success','Company Reply to Email updated');
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

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCurrencySymbol($id)
    {
         $currency = CurrencySymbol::findOrFail($id);
         if($currency){
            $currency->delete();
        return redirect()->back()->withStatus(__('Currency symbol deleted successfully'));
         }
    }


}
