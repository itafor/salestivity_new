<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    // Create a many to many polymorphic relationship btw payment and product model
    public function productsMorph()
    {
        return $this->morphedByMany('App\Product', 'payable');
    }


    // Create a many to many polymorphic relationship btw payment and renewal model
    public function renewalsMorph()
    {
        return $this->morphedByMany('App\Renewal', 'payable');
    }

    // Create a many to many polymorphic relationship btw payment and invoice model
    public function invoicesMorph()
    {
        return $this->morphedByMany('App\Invoice', 'payable');
    }

    public function product()
    {
        return $this->belongsToMany('App\Product', 'payment_product');
    }

    // Show price of product in a specific way
    public function formatValue($value)
    {
        return number_format($value);
    }
}
