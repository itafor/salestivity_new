<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
     use SoftDeletes;


      protected $fillable = [
        'productPrice','billingAmount', 'amount_paid','billingbalance','discount',
        'payment_date','customer_id','product_id','created_by_id','invoice_id',
        'status','user_type','amount_paid'
    ];

     public function product(){
    	return $this->belongsTo(Product::class,'product_id','id');
    }

    public function customer(){
    	return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function invoice(){
    	return $this->belongsTo(Invoice::class,'invoice_id','id');
    }

     public static function createNew($data){

    	$invoce_Payment = self::create([
		'created_by_id' =>  getActiveGuardType()->created_by,
		'user_type' =>  getActiveGuardType()->user_type,
		'productPrice' => $data['productPrice'],
		'discount' => $data['discount'],
		'billingAmount' => $data['billingAmount'],
		'amount_paid' => $data['amount_paid'],
		'billingbalance' =>$data['billingAmount'] - $data['amount_paid'],
		'payment_date' => Carbon::parse(formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d')),
		'customer_id' => $data['customer_id'],
		'product_id' => $data['product_id'],
		'invoice_id' => $data['invoice_id'],
    	]);


    	if($invoce_Payment){
    		self::updatePaymentStatus($invoce_Payment);
    		self::updateInvoiceBillingBalance($data,$invoce_Payment);
    	}

    	return $invoce_Payment;
    }

  public static function updatePaymentStatus($invoicePayment){
       		$getPayment = self::where('id', $invoicePayment->id)->first();
	if($getPayment){
		$getPayment->status = $invoicePayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
		$getPayment->save();
	}	
 }

  public static function updateInvoiceBillingBalance($data, $invicePayment){
       		$getInvoice = Invoice::where('id', $invicePayment->invoice_id)->first();
       		if($getInvoice){
            $getInvoice->billingbalance = $invicePayment->billingbalance;
            $getInvoice->amount_paid += $invicePayment->amount_paid;
      			$getInvoice->status = $invicePayment->billingbalance == 0 ? 'Paid' : 'Partly paid';
      			$getInvoice->save();
      		}	
       }


  public static function deleteInvoicePaymentHistory($invoiceId) {
    $payments = self::where('invoice_id',$invoiceId)->get();
    if($payments){
      foreach ($payments as $key => $val) {
        $val->delete();
    }
  }
}
}