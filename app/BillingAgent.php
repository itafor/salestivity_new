<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingAgent extends Model
{
    use SoftDeletes;
	
    protected $fillable = ['customer_id','main_acct_id','name','phone','email'];


  public function customer(){
    	return $this->belongsTo(Customer::class,'customer_id','id');
    }
  
  public static function createNew($data){

    	$billing_agent = self::create([
		'main_acct_id' =>  auth()->user()->id,
		'customer_id' => $data['customer_id'],
		'phone' => $data['phone'],
		'name' => $data['name'],
		'email' => $data['email'],
    	]);
    	return $billing_agent;
    }
}
