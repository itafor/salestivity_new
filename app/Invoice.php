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
        return $this->belongsTo('App\Customer', 'customer', 'id');
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

     public function contacts(){
        return $this->hasMany(InvoiceContact::class,'invoice_id','id');
    }

      public function user()
    {
        return $this->belongsTo('App\User', 'main_acct_id');
    }

    public function replyToEmailAddress()
    {
        return $this->belongsTo('App\ReplyToEmail', 'reply_to_email_id');
    }

    public function getMailFromName()
    {
        return $this->belongsTo('App\MailFromName', 'mail_from_name_id');
    }

     public function ccEmailAddress()
    {
        return $this->belongsTo('App\CarbonCopyEmail', 'cc_email_id');
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

   public function compEmail()
    {
        return $this->belongsTo('App\CompanyEmail', 'company_email_id','id');
    }

    public function compBankAcct()
    {
        return $this->belongsTo('App\CompanyAccountDetail', 'company_bank_acc_id','id');
    }
       public function currency()
    {
        return $this->belongsTo('App\CurrencySymbol', 'currency_id','id');
    }

    public function invoiceProducts()
     {
        return $this->hasMany(InvoiceProduct::class,'billing_invoice_id','id');
    }
}
