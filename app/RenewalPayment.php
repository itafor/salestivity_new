<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalPayment extends Model
{
    use SoftDeletes;

      protected $fillable = [
        'productPrice','billingAmount', 'amount_paid','balance','discount',
        'payment_date','customer_id','product_id','main_acct_id','renewal_id',
        'status'
    ];
}