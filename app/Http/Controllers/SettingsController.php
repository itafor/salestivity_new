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
