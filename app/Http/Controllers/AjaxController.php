<?php

namespace App\Http\Controllers;

use App\City;
use App\Contact;
use App\Customer;
use App\Department;
use App\Invoice;
use App\InvoicePayment;
use App\Opportunity;
use App\OpportunityProduct;
use App\Product;
use App\Renewal;
use App\RenewalPayment;
use App\State;
use App\SubUser;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AjaxController extends Controller
{

 public function destroyItems($itemModel, $id)
    {
        if($itemModel == 'renewal'){
        $renewal = Renewal::find($id);
         RenewalPayment::deletePaymentHistory($renewal->id);
         $renewal->delete();
    return redirect()->route('billing.renewal.index')->with('success','Renewal deleted!!');
    }elseif ($itemModel == 'invoice') {
         $invoice = Invoice::find($id);
        // dd($invoice);
         InvoicePayment::deleteInvoicePaymentHistory($invoice->id);
         $invoice->delete();
    return redirect()->route('billing.invoice.index')->with('success','Invoice deleted!!');
    }elseif ($itemModel == 'opportunityProduct') {
         $oppProd = OpportunityProduct::find($id);
         $oppProd->delete();
        Alert::success('Product', 'Deleted');
        return back();
}
}

    public function getContacts($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $contacts = Contact::where('customer_id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['contacts' => $contacts]);
    }

    public function getOpportunities($id)
    {
        if($id == 1){
            $opportunities = Opportunity::all();
            
            return response()->json(['opportunities' => $opportunities]);
        } elseif($id == 2) {
            dd(Carbon::today());
        }
    }

    public function getDept($id)
    {

        $userId = \getActiveGuardType()->main_acct_id;
        $units = Unit::where('dept_id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['units' => $units]);
    }
    
    public function getProductPrice($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $products = Product::where('id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['products' => $products]);
    }
     
     public function fetchSelectedProductPrice($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $products = Product::where('id', $id)->first();

        return response()->json([
            'products' => $products,
            'category' => $products->category ? $products->category->name : 'N/A',
            'subcategory' => $products->sub_category ? $products->sub_category->name : 'N/A',
        ]);
    }

     public function fetchRenewalDetails($id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $renewal = Renewal::where('id', $id)->first();
        return response()->json(['renewal' => $renewal]);
    }

     public function fetchInvoiceDetails($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        return response()->json(['invoice' => $invoice]);
    }
    
    public function validateSelectedPaymentDate($selected_date){

        $payment_date = str_replace("-","/",$selected_date);
        date_default_timezone_set("Africa/Lagos");
        $pay_date   = Carbon::parse(formatDate($payment_date, 'd/m/Y', 'Y-m-d'));
        $today = Carbon::now()->format('d/m/Y');
        $current_timestamp = Carbon::parse(formatDate($today, 'd/m/Y', 'Y-m-d'));

    if($pay_date > $current_timestamp){
        return 'invalidate';
    }
    }

public function increaseStartDatebyOneYear($selected_date){

        $startDate = str_replace("-","/",$selected_date);
       $increased_date = Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d'))->addYear()->format('d/m/Y');

        return $increased_date;
    }
public function getContactEmails($id) {
    $customer = Customer::where('id',$id)->first();
    $contacts = $customer->contacts;
        return response()->json(['contacts' => $contacts]);
}

public function getCompanyEmail($id)
{
    $customer = Customer::where('id',$id)->get();
    $contact = $customer;
        return response()->json(['contact' => $contact]);
}

    public function getSalesDept($id)
    {

        $userId = \getActiveGuardType()->main_acct_id;
        $depts = Department::where('id', $id)->where('main_acct_id', $userId)->get();
        return response()->json(['depts' => $depts]);
    }

    public function getState($id)
    {
        $states = State::where('country_id', $id)->get();
        return response()->json(['states' => $states]);
    }

    public function getCity($id)
    {
        $cities = City::where('state_id', $id)->get();
        return response()->json(['cities' => $cities]);
    }


    public function checkUserLevel($id)
    {
        $user = SubUser::where([
            ['id', $id],
            ['level', '!=',null]
        ])->first();
        return response()->json(['user' => $user]);
    }

    
}
