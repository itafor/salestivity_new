<?php

namespace App;
use App\Customer;
use App\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer');
    }

     public function prod()
    {
        return $this->belongsTo('App\Product', 'product_id','id');
    }

     public function category()
    {
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\SubCategory', 'subcategory_id','id');
    }

     public function invoicePayment(){
        return $this->hasMany(InvoicePayment::class,'invoice_id','id');
    }

      public function user()
    {
        return $this->belongsTo('App\User', 'main_acct_id');
    }

    public function getCustomerName($id)
    {
        $invoice = Invoice::where('customer', $id)->get()->first();
        $customer = Customer::find($invoice->customer);
        // dd($invoice->customer);

        return $customer->company_name;
    }

    public function getProductName($id)
    {
        $invoice = Invoice::where('product', $id)->get()->first();
        $product = Product::find($invoice->product);
        // dd($invoice->customer);
        
        return $product->name;
    }

    public function payments()
    {
        return $this->morphToMany('App\Payment', 'payable');
    }
}
