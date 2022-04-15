<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory;
     use SoftDeletes;

    protected $fillable = [
    	'user_id',
    	'product_id',
    	'inventory_id',
    	'attribute',
    	'comment',
        'user_type'
    ];
   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

       public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

      public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

}
