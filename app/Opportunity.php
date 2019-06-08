<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class Opportunity extends Model
{
    // Relationship between Customer and Opportunity model
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'account_id');
    }

    public function contact_person()
    {
        return $this->belongsTo('App\Contact', 'contact');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'opportunity_product', 'opportunity_id', 'product_id')
                            ->withPivot('product_category', 'product_sub_category', 'product_name',
                            'product_qty', 'product_price')->withTimestamps();
    }

    public function getCustomerName($id){
        $customer = Customer::where('id', $id)->get();

        return $customer->name;
    }
}
