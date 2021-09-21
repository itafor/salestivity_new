<?php

namespace App\Http\Controllers;

use App\CompanyAccountDetail;
use App\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BankAccountController extends Controller
{

	public function __construct()
    {
        $this->middleware(['auth','mainuserVerified','subuserVerified'])->except('homepage');
    }
    
     public function index()
    {
        $data['user'] = User::where('id', getActiveGuardType()->main_acct_id)->first();
              $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
            
        return view('settings.bankAccounts', $data);
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
        
       return redirect()->route('bank.account.index');
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
        
       return redirect()->route('bank.account.index');
    }
}
