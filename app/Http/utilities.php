<?php

use App\CarbonCopyEmail;
use App\Category;
use App\City;
use App\CompanyAccountDetail;
use App\CompanyDetail;
use App\CompanyEmail;
use App\Contact;
use App\Country;
use App\Customer;
use App\Industry;
use App\Invoice;
use App\InvoicePayment;
use App\MailFromName;
use App\Product;
use App\Renewal;
use App\RenewalPayment;
use App\ReplyToEmail;
use App\State;
use App\SubCategory;
use App\SubUser;
use App\User;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


function formatDate($date, $oldFormat, $newFormat)
{
    return Carbon::createFromFormat($oldFormat, $date)->format($newFormat);
}

function generateUUID()
{
    return Str::uuid()->toString();
}

function compareEndStartDate($start_date, $end_date)
{
    date_default_timezone_set("Africa/Lagos");
    $startdate = Carbon::parse(formatDate($start_date, 'd/m/Y', 'Y-m-d'));
    $enddate   =   Carbon::parse(formatDate($end_date, 'd/m/Y', 'Y-m-d'));

    if ($enddate < $startdate) {
        return false;
    } else {
        return true;
    }
}

function authUserId()
{
    return auth()->user()->id;
}

function mainUserId($id = null)
{
    return $id;
}


function getIndustries()
{
    $industries = Industry::all();
    return $industries;
}

function getCountries()
{
    $countries = Country::all();
    return $countries;
}

function getStates()
{
    $states = State::all();
    return $states;
}

function getCities()
{

    $cities = City::all();
    if ($cities) {
        return $cities;
    }
    // $chunkedCities = [];
    // City::chunk(100, function($cities) use (&$chunkedCities){
    //     foreach ($cities as $key => $city) {
    //        $chunkedCities[] = $city;
    //     }
    // });
    // if ($chunkedCities) {
    //     return $chunkedCities;
    // }

    
}

function productCategories()
{
    $categories = Category::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
    if ($categories) {
        return $categories;
    }
}

function productSubCategories()
{
    $sub_categories = SubCategory::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
    if ($sub_categories) {
        return $sub_categories;
    }
}

/**
 * This function gets the current logged in user guard type
 */
function getActiveGuardType()
{
    // get the user guard type
    if (auth()->guard('sub_user')->check()) {
        // get the sub_user's main_acct_id
        $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
        $created_by = auth()->guard('sub_user')->user()->id;
        $userType = 'sub_users';

        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];
        return $objectResult;
    }
    if (auth()->user()) {
        $main_acct_id = auth()->user()->id;
        $created_by = auth()->user()->id;
        $userType = 'users';
        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];

        return $objectResult;
    }

    if (auth()->guard('admin')->check()) {
        // get the admin's main_acct_id
        $main_acct_id = auth()->guard('admin')->user()->main_acct_id;
        $created_by = auth()->guard('admin')->user()->id;
        $userType = 'admins';

        $objectResult = (object) [
            'main_acct_id' => $main_acct_id,
            'created_by' => $created_by,
            'user_type' => $userType
        ];
        return $objectResult;
    }
}

/**
 * Get created by name
 */
function getCreatedByDetails($userType, $userId)
{
    if ($userType === 'users') {
        $user = User::find($userId);
        // dd(gettype($user));
        return $user;
    }
    if ($userType === 'sub_users') {
        $user = SubUser::find($userId);
        return $user;
    }
}

function convertNumberToWord($number)
{
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return $f->format($number);
}

function authUser()
{
    return auth()->user();
}

function customerContacts($customerId)
{
    return Contact::where([
        ['main_acct_id',getActiveGuardType()->main_acct_id],
        ['customer_id',$customerId]
    ])->get();
}

function allCustomers()
{
    return Customer::all();
}

function mySubUsers()
{
    return SubUser::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
}

function addMainAccountOwnerToSubUser()
{
    if (getActiveGuardType()->user_type == 'users') {
        $emailExist = SubUser::where('email', authUser()->email)->first();
        if (!$emailExist) {
            $user = new SubUser;
            $user->name = authUser()->name;
            $user->last_name = authUser()->last_name;
            $user->email = authUser()->email;
            $user->main_acct_id = authUser()->id;
            $user->password = Hash::make('password1xxx');
            $user->save();
        }
    }
}

function updatePrimaryUserLevel()
{
    if (getActiveGuardType()->user_type == 'users') {
        $primary_user = SubUser::where('email', authUser()->email)->first();
        if ($primary_user && $primary_user->level == null) {
            $primary_user->level = 1;
            $primary_user->password = Hash::make('password1xxx');

            $primary_user->save();
        }
    }
}

function subuser($email)
{
    return SubUser::where('email', $email)->first();
}

function users_that_reports_to_main_user()
{
    $guard_object = getActiveGuardType();
    if ($guard_object->user_type == 'users') {
        $get_main_user_from_subuser = SubUser::where('email', authUser()->email)->first();

        return $get_main_user_from_subuser->users_that_report_tome;
    }

    return authUser()->users_that_report_tome;
}

function uploadImage($image)
{
    if (isset($image)) {
        if ($image->isValid()) {
            $trans = array(
                ".png" => "",
                ".PNG" => "",
                ".JPG" => "",
                ".jpg" => "",
                ".jpeg" => "",
                ".JPEG" => "",
                ".bmp" => "",
                ".pdf" => "",
            );
            $uploadedFileUrl = Cloudinary::uploadFile($image->getRealPath())->getSecurePath();
        }
    }
    return $uploadedFileUrl;
}

function company_details_alerts()
{
    $data['user'] = User::where([
        ['id', getActiveGuardType()->main_acct_id],
        ['company_logo_url', '!=', null]
    ])->first();
    $data['companyDetail'] = CompanyDetail::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
            ['name', '!=', null]
        ])->first();
    $data['companyEmails'] = CompanyEmail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
    $data['companyBankDetails'] = CompanyAccountDetail::where('main_acct_id', getActiveGuardType()->main_acct_id)->get();
    if ($data['user'] == '' || $data['companyDetail'] == '' || $data['companyEmails'] == '' || $data['companyBankDetails'] == '') {
        return  'show alert';
    }
}

function loginUserId()
{
    if (getActiveGuardType()->user_type == 'users') {
        $user = SubUser::where('email', authUser()->email)->first();
        return $user->id;
    } elseif (getActiveGuardType()->user_type == 'sub_users') {
        return auth()->guard('sub_user')->user()->id;
    }
}

function whatsappNotification($from_number, $to_number, $text_messages)
{
    $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
    $params = ["to" => ["type" => "whatsapp", "number" =>$to_number],
        "from" => ["type" => "whatsapp", "number" => $from_number],
        "message" => [
            "content" => [
                "type" => "text",
                "text" => $text_messages
            ]
        ]
    ];
    $headers = ["Authorization" => "Basic " . base64_encode('3eae53b5'. ":" . '5vaBUvs8KEgwWMne')];

    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
    $data = $response->getBody();
    Log::Info($data);
}

 function renewalPaymentStatus($renewal)
   {
        if(isset($renewal)){
        if($renewal->status == 'Partly paid'){
        return  "partly_paid";
        }elseif($renewal->status == 'Pending'){
         return "Pending";
        }elseif($renewal->status == 'Paid'){
         return "paid";
        }else{
         return "all";
        }
        }
    }

    function invoicePaymentStatus($invoice)
    {
        if(isset($invoice)){
        if($invoice->status == 'Partly paid'){
        return "partly_paid";
        }elseif($invoice->status == 'Pending'){
        return "outstanding";
        }elseif($invoice->status == 'Paid'){
       return "paid";
        }else{
        return "all";
        }
        }

    }

    function getMailFromName($invoice)
    {
        // $default_mail_from_name = MailFromName::where([
        //     ['main_acct_id', $invoice->user->id],
        //     ['default_name', 'Default'],
        // ])->first();

        if($invoice->mail_from_name){
            return $invoice->mail_from_name;
       }else{
            return $invoice->user->company_name;
        }
    }

  function getReplyToEmailAddress($invoice)
    {
        $default_replyTo_email = ReplyToEmail::where([
            ['main_acct_id', $invoice->user->id],
            ['default_email', 'Default'],
        ])->first();

        if($invoice->replyToEmailAddress){
            return $invoice->replyToEmailAddress->reply_to_email;
        }elseif($default_replyTo_email){
            return $default_replyTo_email->reply_to_email;
        }else{
            return $invoice->user->email;
        }
    }

     function getUserCCEmailAddress($invoice)
    {
        
        if($invoice->ccEmailAddress){
            return $invoice->ccEmailAddress->cc_email;
        }else{
            return $invoice->user->email;
        }
    }

    function getCompanyName($user)
    {
        
        if($user){
            return $user->company_name;
        }
    }


 // ......paid Renewal (Recurring) Year to Date ......................
    function yearToDatePaidRenewal()
    {
        $curr_year = Carbon::now('y');

        $yearToDatepartially_paid_renewal = RenewalPayment::where([
            ['status', 'Partly paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereYear('payment_date', $curr_year)->get();

         $year_to_date_completely_paid_renewal = RenewalPayment::where([
            ['status', 'Paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereYear('payment_date', $curr_year)->get();
      

     $data['yeartodate_partially_paid_renewal_amt'] = $yearToDatepartially_paid_renewal->sum('amount_paid');

     $data['year_to_date_completely_paid_renewal_amt'] = $year_to_date_completely_paid_renewal->sum('amount_paid'); 

     $data['paid_recurring_amount_for_year_to_date'] = $data['yeartodate_partially_paid_renewal_amt'] + $data['year_to_date_completely_paid_renewal_amt'];

       $paid_renewal_count = RenewalPayment::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
     ])->whereYear('payment_date', $curr_year)->distinct()->get('renewal_id');

     return [
        'paid_amount' =>   $data['paid_recurring_amount_for_year_to_date'],
        'numberOfRenewals' => count($paid_renewal_count)
     ];

    }

    function currentMonthPaidRenewalInvoices()
    {
        $curr_momth = Carbon::now('m');

     $currentMonthpartially_paid_renewal = RenewalPayment::where([
            ['status', 'Partly paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereMonth('payment_date', $curr_momth)->get();

         $current_month_completely_paid_renewal = RenewalPayment::where([
            ['status', 'Paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereMonth('payment_date', $curr_momth)->get();
      

     $data['current_month_partially_paid_renewal_amt'] = $currentMonthpartially_paid_renewal->sum('amount_paid');

     $data['current_month_completely_paid_renewal_amt'] = $current_month_completely_paid_renewal->sum('amount_paid'); 

     $data['paid_recurring_amount_for_current_month'] = $data['current_month_partially_paid_renewal_amt'] + $data['current_month_completely_paid_renewal_amt'];

     $paid_renewal_count = RenewalPayment::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
     ])->whereMonth('payment_date', $curr_momth)->distinct()->get('renewal_id');

     return [
        'paid_amount' =>  $data['paid_recurring_amount_for_current_month'],
        'numberOfRenewals' => count($paid_renewal_count)
     ];

    }

    function currentMonthOutstandingRenewal()
    {
        $curr_momth = Carbon::now('m');

        $renewals = Renewal::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['billingBalance', '>', 0],
    ])->whereMonth('created_at', $curr_momth)->get();

     return [
        'renewal' => $renewals->sum('billingBalance'),
        'renewalCount' => count($renewals)
     ];
    }

  function yearToDateOutstandingRenewal()
    {
        $curr_year = Carbon::now('y');

        $renewals = Renewal::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['billingBalance', '>', 0],
    ])->whereYear('created_at', $curr_year)->get();

     return [
        'renewal' => $renewals->sum('billingBalance'),
        'renewalCount' => count($renewals)
     ];
    }

    function currentMonthPaidInvoice()
    {
        $curr_momth = Carbon::now('m');

         $currentMonthpartially_paid_invoice = InvoicePayment::where([
            ['status', 'Partly paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereMonth('payment_date', $curr_momth)->get();

         $current_month_completely_paid_invoice = InvoicePayment::where([
            ['status', 'Paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereMonth('payment_date', $curr_momth)->get();

         $current_month_paid_invoice_amount = $currentMonthpartially_paid_invoice->sum('amount_paid') + $current_month_completely_paid_invoice->sum('amount_paid');

     $invoice_count = InvoicePayment::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
     ])->whereMonth('payment_date', $curr_momth)->distinct()->get('invoice_id');

     return [
        'invoice_amount' =>  $current_month_paid_invoice_amount,
        'invoice_count' => count($invoice_count)
     ];

    }

    function yearToDatePaidInvoice()
    {
        $curr_year = Carbon::now('y');

         $year_to_date_partially_paid_invoice = InvoicePayment::where([
            ['status', 'Partly paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereYear('payment_date', $curr_year)->get();

         $year_to_date_completely_paid_invoice = InvoicePayment::where([
            ['status', 'Paid'],
           ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->whereYear('payment_date', $curr_year)->get();

         $ytd_paid_invoice_amount = $year_to_date_partially_paid_invoice->sum('amount_paid') + $year_to_date_completely_paid_invoice->sum('amount_paid');

        $invoice_count = InvoicePayment::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
     ])->whereYear('payment_date', $curr_year)->distinct()->get('invoice_id');

     return [
        'invoice_amount' =>  $ytd_paid_invoice_amount,
        'invoice_count' => count($invoice_count)
     ];

    }

  function currentMonthOutstandingInvoices()
    {
        $curr_momth = Carbon::now('m');

        $invoices = Invoice::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['billingBalance', '>', 0],
    ])->whereMonth('created_at', $curr_momth)->get();

     return [
        'invoice' => $invoices->sum('billingBalance'),
        'invoiceCount' => count($invoices)
     ];
    }

      function yearToDateOutstandingInvoices()
    {
        $curr_year = Carbon::now('y');

        $invoices = Invoice::where([
        ['main_acct_id', getActiveGuardType()->main_acct_id],
        ['billingBalance', '>', 0],
    ])->whereYear('created_at', $curr_year)->get();

     return [
        'invoice' => $invoices->sum('billingBalance'),
        'invoiceCount' => count($invoices)
     ];
    }

     function getValueAddedTax($price, $vat){
         $vat = $vat == '' ? 0 : $vat;

    $vat_Price = ($vat / 100) * $price;
     return $vat_Price;

   }

   function getWithholdingTax($price, $wht){
         $wht = $wht == '' ? 0 : $wht;
    $wht_Price = ($wht / 100) * $price;
     return $wht_Price;

   }

 function getFinalPrice($discount, $productPrice, $value_added_tax, $withholding_tax)
 {
     $discountValue = $discount == '' ? 0 : $discount;
        $discountedPrice = ($discountValue / 100) * $productPrice;
        $final_Price = $productPrice - $discountedPrice;

        $finalPrice = $final_Price + getValueAddedTax($final_Price, $value_added_tax) + getWithholdingTax($final_Price, $withholding_tax);

        return $finalPrice;
 }