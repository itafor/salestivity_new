<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpportunityProduct extends Model
{
    protected $fillable =['product_id','opportunity_id'];

    public function produc(){
    	return $this->belongsTo(Product::class,'product_id','id');
    }

     public function opportunity(){
    	return $this->belongsTo(Opportunity::class,'opportunity_id','id');
    }
}
