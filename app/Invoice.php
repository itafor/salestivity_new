<?php

namespace App;
use App\Customer;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer');
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
}
