<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Create a many to many relationship btw product and category model
    public function category()
    {
        return $this->belongsToMany('App\Category', 'category_product', 'category_id');
    }

     // Create a one to many relationship btw product and category model
     public function sub_category()
     {
         return $this->belongsTo('App\SubCategory', 'sub_category_id');
     }

     // Create a many to many relationship btw product and payment model
    public function payments()
    {
        return $this->belongsToMany('App\Payment', 'payment_product', 'payment_id');
    }
}
