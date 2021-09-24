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
