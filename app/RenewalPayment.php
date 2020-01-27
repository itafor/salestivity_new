<?php

namespace App;

use App\Renewal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalPayment extends Model
{
    use SoftDeletes;

      protected $fillable = [
        'productPrice','billingAmount', 'amount_paid','billingbalance','discount',
        'payment_date','customer_id','product_id','main_acct_id','renewal_id',
        'status'
    ];

    public function user(){
    	return $this->belongsTo(User::class,'main_acct_id','id');
    }

    public function product(){
    	return $this->belongsTo(Product::class,'product_id','id');
    }

    public function customer(){
    	return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function renewal(){
    	return $this->belongsTo(Renewal::class,'renewal_id','id');
    }

     public static function createNew($data){

    	$renewalPayment = self::create([
		'main_acct_id' =>  auth()->user()->id,
		'productPrice' => $data['productPrice'],
		'discount' => $data['discount'],
		'billingAmount' => $data['billingAmount'],
		'amount_paid' => $data['amount_paid'],
		'billingbalance' => $data['billingbalance'],
		'payment_date' => Carbon::parse(formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d')),
		'customer_id' => $data['customer_id'],
		'product_id' => $data['product_id'],
		'renewal_id' => $data['renewal_id'],
    	]);


    	if($renewalPayment){
    		self::updatePaymentStatus($renewalPayment);
    		self::updateRenewalBillingBalance($data,$renewalPayment);
    	}

    	return $renewalPayment;
    }

  public static function updatePaymentStatus($renewalPayment){
       		$getPayment = self::where('id', $renewalPayment->id)
       						->where('customer_id',$renewalPayment->customer_id)
       						->where('main_acct_id',auth()->user()->id)->first();
	if($getPayment){
		$getPayment->status = $renewalPayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
		$getPayment->save();
	}	
 }

  public static function updateRenewalBillingBalance($data, $renewalPayment){
       		$getRenewal = Renewal::where('id', $renewalPayment->renewal_id)
       						->where('main_acct_id',auth()->user()->id)->first();
       		if($getRenewal){
            $getRenewal->billingbalance = $renewalPayment->billingbalance;
      			$renewalPayment->status = $renewalPayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
      			$getRenewal->save();
      		}	
       }
}