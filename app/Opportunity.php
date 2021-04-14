<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Customer;

class Opportunity extends Model
{
    use SoftDeletes;
    
    // Relationship between Customer and Opportunity model
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'account_id');
    }

    public function contact_person()
    {
        return $this->belongsTo('App\Contact', 'contact_id','id');
    }

    public function owner()
    {
        return $this->belongsTo('App\SubUser', 'owner_id','id');
    }

    public function opp_product(){
        return $this->hasMany(OpportunityProduct::class,'opportunity_id','id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'opportunity_product', 'opportunity_id', 'product_id')
                            ->withPivot('product_category', 'product_sub_category', 'product_name',
                            'product_qty', 'product_price', 'main_acct_id')->withTimestamps();
    }

    public function getCustomerName($id){
        $userId = auth()->user()->id;
        $customer = Customer::where('id', $id)->where('main_acct_id', $userId)->get();

        return $customer->name;
    }

     public function opp_updates(){
        return $this->hasMany(OpportunityUpdate::class,'opportunity_id','id');
    }
}
