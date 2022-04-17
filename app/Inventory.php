<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
    	'main_acct_id',
    	'customer_id',
        'product_id',
    	'order_id',
    	'quantity',
        'status',
        'user_type'
    ];
   
    public function user()
    {
        return $this->belongsTo(User::class, 'main_acct_id', 'id');
    }

     public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
