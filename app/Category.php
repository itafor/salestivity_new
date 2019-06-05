<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Create a many to many relationship btw product and category model
    public function product()
    {
        return $this->belongsToMany('App\Product', 'category_product');
    }
}
