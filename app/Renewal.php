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

    public function payments()
    {
        return $this->morphToMany('App\Payment', 'payable');
    }

    public function product_name(){
        return $this->belongsTo('App\Product','product');
    }

    public function renewalPayment(){
        return $this->hasMany(RenewalPayment::class);
    }

    public static function createNew($data) {
    	$renewal = self::create([
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
}
