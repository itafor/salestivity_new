<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    // Create a many to many relationship btw product and category model
    public function category()
    {
        //return $this->belongsTo('App\Category', 'category_id');
        return $this->belongsTo('App\Category', 'category_id','id');
    }

     // Create a one to many relationship btw product and category model
     public function sub_category()
     {
         return $this->belongsTo('App\SubCategory', 'sub_category_id','id');
     }

     // Create a many to many relationship btw product and payment model
    public function payments()
    {
        return $this->belongsToMany('App\Payment', 'payment_product', 'payment_id');
    }

    public function opportunities()
    {
        return $this->belongsToMany('App\Opportunity', 'opportunity_product', 'opportunity_id', 'product_id')
                            ->withPivot('product_category', 'product_sub_category', 'product_name',
                            'quantity', 'price')->withTimestamps();
    }

    public function renewalPayment(){
        return $this->hasMany(RenewalPayment::class);
    }

      public static function updateProduct($data)
    {

     $product  =  self::where([
            ['id', $data['product_id'] ],
        ])->update([
           'category_id' => $data['category_id'],
           'sub_category_id' => $data['sub_category_id'],
           'name' => $data['name'],
           'description' =>  $data['description'],
           'standard_price' =>  $data['standard_price'],
        ]); 

        return $product;

    }

}
