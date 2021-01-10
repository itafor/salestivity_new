<?php

namespace App;

use App\Renewal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalPayment extends Model
{
    use SoftDeletes;

      protected $fillable = [
        'productPrice','billingAmount', 'amount_paid','billingbalance','discount',
        'payment_date','customer_id','product_id','main_acct_id','renewal_id','created_by_id',
        'status','user_type'
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
		'main_acct_id' => getActiveGuardType()->main_acct_id,
    'created_by_id' =>  getActiveGuardType()->created_by,
    'user_type' => getActiveGuardType()->user_type,
		'productPrice' => $data['productPrice'],
		'discount' => $data['discount'],
		'billingAmount' => $data['billingAmount'],
		'amount_paid' => $data['amount_paid'],
		'billingbalance' =>$data['billingAmount'] - $data['amount_paid'],
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
       		$getPayment = self::where('id', $renewalPayment->id)->first();
	if($getPayment){
		$getPayment->status = $renewalPayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
		$getPayment->save();
	}	
 }

  public static function updateRenewalBillingBalance($data, $renewalPayment){
       		$getRenewal = Renewal::where('id', $renewalPayment->renewal_id)->first();
       		if($getRenewal){
            $getRenewal->billingbalance = $renewalPayment->billingbalance;
             $getRenewal->amount_paid += $renewalPayment->amount_paid;
      			$getRenewal->status = $renewalPayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
      			$getRenewal->save();
      		}	
       }

  public static function deletePaymentHistory($renewalId) {
    $payments = self::where('renewal_id',$renewalId)->get();
    if($payments){
      foreach ($payments as $key => $val) {
        $val->delete();
    }
  }
}

}