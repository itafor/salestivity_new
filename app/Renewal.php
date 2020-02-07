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
        'description','status'
    	];

    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\renewalContactEmail', 'renewal_id','id');
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

    public static function createNew($data) {
        $contactEmails = isset($data['contact_emails']) ? $data['contact_emails'] : '' ;
       
        $discountValue = $data['discount'] == '' ? 0 : $data['discount'];
        $discountedPrice = ($discountValue / 100) * $data['productPrice'];
        $finalPrice = $data['productPrice'] - $discountedPrice;

    	$renewal = self::create([
    	'main_acct_id' => auth()->user()->id,
        'customer_id' => $data['customer_id'],
        'product' => $data['product'],
        'productPrice' => $data['productPrice'],
        'discount' => $data['discount'],
        'billingAmount' =>  $finalPrice,  //$data['billingAmount'],
        'billingBalance' => $finalPrice,  //$data['billingAmount'],
        'description' => $data['description'],
        'start_date' => Carbon::parse(formatDate($data['start_date'], 'd/m/Y', 'Y-m-d')),
        'end_date' => Carbon::parse(formatDate($data['end_date'], 'd/m/Y', 'Y-m-d')),
    	]);

        if($renewal){
           self::createRenewalContactEmail($renewal,$contactEmails);
        }
    	return $renewal;
    }

    public static function updateRenewal($data)
    {
        self::where('id', $data['renewal_id'])->update([
        'main_acct_id' => auth()->user()->id,
        'customer_id' => $data['customer_id'],
        'product' => $data['product'],
        'productPrice' => $data['productPrice'],
        'discount' => $data['discount'],
        'billingAmount' => $data['billingAmount'],
        'billingBalance' => $data['billingAmount'],
        'description' => $data['description'],
        'start_date' => Carbon::parse(formatDate($data['start_date'], 'd/m/Y', 'Y-m-d')),
        'end_date' => Carbon::parse(formatDate($data['end_date'], 'd/m/Y', 'Y-m-d')),
        ]); 
    }

 public static function createRenewalContactEmail($renewal,$contactEmails) {

   
    if($contactEmails !='' && $contactEmails[0] != null){
    foreach ($contactEmails as $key => $contactEmail) {
       $renewalContact = new renewalContactEmail();
       $renewalContact->contact_id = $contactEmail;
       $renewalContact->renewal_id = $renewal->id;
       $renewalContact->save();
    }

  }

 }
}
