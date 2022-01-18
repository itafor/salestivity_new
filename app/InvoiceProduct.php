<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    protected $fillable= ['billing_invoice_id', 'product_id'];

    public function product()
    {
    	return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
