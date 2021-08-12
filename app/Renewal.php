<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renewal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'main_acct_id', 'customer_id', 
        'product','start_date',
        'end_date','amount','productPrice',
        'discount','billingAmount','billingBalance',
        'description','status','userType','created_by_id','amount_paid',
        'category_id','subcategory_id','product_id','duration_type', 'first_reminder_sent', 'invoice_number','company_email_id','company_bank_acc_id'
    	];

    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\renewalContactEmail', 'renewal_id','id');
    }

     public function duration()
    {
        return $this->hasOne('App\RenewalReminderDuration', 'renewal_id','id');
    }


    public function payments()
    {
        return $this->morphToMany('App\Payment', 'payable');
    }

    public function product_name(){
        return $this->belongsTo('App\Product','product');
    }

    public function renewalPayment(){
        return $this->hasMany(RenewalPayment::class,'renewal_id','id');
    }
    
    public function prod()
    {
        return $this->belongsTo('App\Product', 'product_id','id');
    }

     public function category()
    {
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\SubCategory', 'subcategory_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'main_acct_id');
    }

     public function compEmail()
    {
        return $this->belongsTo('App\CompanyEmail', 'company_email_id','id');
    }

    public function compBankAcct()
    {
        return $this->belongsTo('App\CompanyAccountDetail', 'company_bank_acc_id','id');
    }

    public static function createNew($data) {

        $guard_object = getActiveGuardType();
        $contactEmails = isset($data['contact_emails']) ? $data['contact_emails'] : '' ;
       
        $discountValue = $data['discount'] == '' ? 0 : $data['discount'];
        $discountedPrice = ($discountValue / 100) * $data['productPrice'];
        $finalPrice = $data['productPrice'] - $discountedPrice;

    	$renewal = self::create([
    	'main_acct_id' => getActiveGuardType()->main_acct_id,
        'created_by_id' =>  getActiveGuardType()->created_by,
        'customer_id' => $data['customer_id'],
        'category_id' => $data['category_id'],
        'subcategory_id' => $data['sub_category_id'],
        'product_id' => $data['product'],
        'productPrice' => $data['productPrice'],
        'discount' => $data['discount'],
        'duration_type' => $data['duration_type'],
        'billingAmount' =>  $finalPrice,  //$data['billingAmount'],
        'billingBalance' => $finalPrice,  //$data['billingAmount'],
        'userType' => getActiveGuardType()->user_type,
        'description' => $data['description'],
        'start_date' => Carbon::parse(formatDate($data['start_date'], 'd/m/Y', 'Y-m-d')),
        'end_date' => Carbon::parse(formatDate($data['end_date'], 'd/m/Y', 'Y-m-d')),
         'first_reminder_sent' => 'no',
         'invoice_number' => 'DW'.mt_rand(1000, 9999),
        'company_email_id' => $data['company_email_id'],
        'company_bank_acc_id' => $data['company_bank_acc_id'],

    	]);

        if($renewal){
           self::createRenewalContactEmail($renewal,$contactEmails);
           self::createRenewalReminderDuration($data, $renewal);
        }
    	return $renewal;
    }

    public static function updateRenewal($data)
    {
        $contactEmails = isset($data['contact_emails']) ? $data['contact_emails'] : '' ;
        $renewal =  self::where('id', $data['renewal_id'])->first();
        $existingBillBal = $renewal->billingBalance;
        $existingBillAmt = $renewal->billingAmount;
        // $paymentStatus = self::getRenewalPaymentStatus($existingBillBal, $existingBillAmt, $data['billingAmount'], $renewal->status);

        // dd($paymentStatus);

        self::where('id', $data['renewal_id'])->update([
        'customer_id' => $data['customer_id'],
        'category_id' => $data['category_id'],
        'subcategory_id' => $data['sub_category_id'],
        'product_id' => $data['product'],
        'productPrice' => $data['productPrice'],
        'discount' => $data['discount'],
        'billingAmount' => $data['billingAmount'],
        // 'billingBalance' => $data['billingAmount'],
        'description' => $data['description'],
        'start_date' => Carbon::parse(formatDate($data['start_date'], 'd/m/Y', 'Y-m-d')),
        'end_date' => Carbon::parse(formatDate($data['end_date'], 'd/m/Y', 'Y-m-d')),
        'duration_type' => $data['duration_type'],
        'company_email_id' => $data['company_email_id'],
        'company_bank_acc_id' => $data['company_bank_acc_id'],
        ]); 

        self::updateRenewalReminderDuration($data);
        self::updateRenewalContactEmail($data, $contactEmails);
    }


    public static function getRenewalPaymentStatus($existingBillBal, $existingBillAmt, $incomingBillAmt, $existingStatus)
    {
            if($existingBillBal == 0 && $incomingBillAmt == $existingBillAmt){
                return 'Paid';
            }elseif ($existingBillBal > 0 && $existingBillBal < $existingBillAmt && $incomingBillAmt >= $existingBillAmt) {
               return 'Partly paid';
            }elseif ($existingBillBal == $existingBillAmt) {
                return 'Pending';
            }else{
              return $existingStatus;
            }
    }

 public static function createRenewalContactEmail($renewal,$contactEmails) {

   
    if($contactEmails !='' && $contactEmails[0] != null){
    foreach ($contactEmails as $key => $contactEmail) {
       $renewalContact = new renewalContactEmail();
       $renewalContact->contact_id = isset($contactEmail['contact_id']) ? $contactEmail['contact_id'] : $contactEmail;
       $renewalContact->renewal_id = $renewal->id;
       $renewalContact->save();
    }

  }

 }

  public static function updateRenewalContactEmail($data, $contactEmails) {

        $renewalContactEmails = renewalContactEmail::where('renewal_id', $data['renewal_id'])->get();
        if(count($renewalContactEmails) >= 1){
            foreach ($renewalContactEmails as $key => $contactEmail) {
                $contactEmail->delete();
            }
        }
   
    if($contactEmails !='' && $contactEmails[0] != null){
    foreach ($contactEmails as $key => $contactEmail) {
       $renewalContact = new renewalContactEmail();
       $renewalContact->contact_id = $contactEmail;
       $renewalContact->renewal_id = $data['renewal_id'];
       $renewalContact->save();
    }

  }

 }

  public static function createRenewalReminderDuration($data, $renewal) {

       $reminderDuration = new RenewalReminderDuration();
       $reminderDuration->renewal_id = $renewal->id;
       $reminderDuration->first_duration = isset($data['first_duration']) ? $data['first_duration'] : null;
       $reminderDuration->second_duration = isset($data['second_duration']) ? $data['second_duration'] : null;
       $reminderDuration->third_duration = isset($data['third_duration']) ? $data['third_duration'] : 0;
       $reminderDuration->save();

 }

   public static function updateRenewalReminderDuration($data) {

       $reminderDuration = RenewalReminderDuration::where('renewal_id', $data['renewal_id'])->first();
       if($reminderDuration){
       $reminderDuration->first_duration = isset($data['first_duration']) ? $data['first_duration'] : null;
       $reminderDuration->second_duration = isset($data['second_duration']) ? $data['second_duration'] : null;
       $reminderDuration->third_duration = isset($data['third_duration']) ? $data['third_duration'] : 0;
       $reminderDuration->save();
    }
 }
}
