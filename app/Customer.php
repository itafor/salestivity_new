<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function address()
    {
        return $this->hasOne('App\AddressCustomer');
    }

    public function invoice()
    {
    	return $this->hasMany('App\Invoice');
    }

    public function renewal()
    {
    	return $this->hasMany('App\Renewal');
    }
}
