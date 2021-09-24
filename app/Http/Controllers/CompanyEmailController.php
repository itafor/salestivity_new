<?php

namespace App\Http\Controllers;

use App\CompanyDetail;
use App\CompanyEmail;
use App\MailFromName;
use App\ReplyToEmail;
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

         $data['reply_to_emails'] = ReplyToEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();

          $data['mail_from_names'] = MailFromName::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
      
            
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



    public function addReplyToEmails(Request $request)
    {
        $data = $request->all();

         $validator = Validator::make($data, [
                'reply_to_email' => ['required', 'string', 'email', 'max:255', 'unique:reply_to_emails'],
        ]);
         if($validator->fails()){
                 
             return back()->withInput()->withErrors($validator);

         }

            ReplyToEmail::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'reply_to_email' => $data['reply_to_email'],
            ]);

             $status = "Company Reply To Email added!!";
        Alert::success('Company Reply to Email', $status);
        
       return redirect()->route('company.email.index')->with('success','Company Reply to Email added');
    }

    
    public function getReplyToEmailById($id){
        $email = ReplyToEmail::findOrFail($id);
        return response()->json(['email'=>$email]);
    }


    public function updateReplyToEmail(Request $request)
    {
        $data = $request->all();
        
         $validator = Validator::make($data, [
                'replyToEmail' => ['required', 'string', 'email', 'max:255'],
                'reply_to_email_id'=>'required',
        ]);
         if($validator->fails()){
             return back()->withErrors($validator);
         }

           $email = ReplyToEmail::findOrFail($data['reply_to_email_id']);
           if($email){
            $email->reply_to_email = $data['replyToEmail'];
            $email->save();
           }

             $status = "Company Reply To Email add!!";
        Alert::success('Company Reply to Email', $status);
        
       return redirect()->route('company.email.index')->with('success','Company Reply to Email added');
    }

    public function setDefaultToEmail($id){

        $emails = ReplyToEmail::where([
                ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();
      
        if(count($emails) >=1){
        foreach ($emails as $key => $email) {
            $email->default_email = null;
            $email->save();
        }
    }
        $email = ReplyToEmail::findOrFail($id);

        if($email){
            $email->default_email = 'Default';
            $email->save();
            $status = "Default Email!!";
        Alert::success('Default Email set successfully', $status);
        return redirect()->route('company.email.index')->with('success','Default ReplyTo Email set');
        }
    }



        public function addMailFromName(Request $request)
    {
        $data = $request->all();

         $validator = Validator::make($data, [
                'mail_from_name' => ['required', 'string', 'max:255', 'unique:mail_from_names'],
        ]);
         if($validator->fails()){
                 
             return back()->withInput()->withErrors($validator);

         }

            MailFromName::create([
                    'main_acct_id' => getActiveGuardType()->main_acct_id,
                    'mail_from_name' => $data['mail_from_name'],
            ]);

             $status = "Company Mail From Name added!";
        Alert::success('Company Reply to Email', $status);
        
       return redirect()->route('company.email.index')->with('success','Company Mail From Name added');
    }

}
