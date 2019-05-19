<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressCustomer extends Model
{
    protected $table = 'address_customer';

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
