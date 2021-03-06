<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use softDeletes;
    // Create a many to many relationship btw product and category model
    // public function product()
    // {
    //     return $this->belongsToMany('App\Product', 'category_product');
    // }

    public function product()
    {
        return $this->hasOne('App\Product', 'category_id');
    }

     public function sub_categories(){
        return $this->hasMany(SubCategory::class,'category_id','id');
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
}
