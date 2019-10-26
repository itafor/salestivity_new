<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    public function address()
    {
        return $this->hasOne('App\AddressCustomer', 'customer_id');
    }

    public function invoice()
    {
    	return $this->hasMany('App\Invoice');
    }

    public function renewal()
    {
    	return $this->hasMany('App\Renewal');
    }

    /**
     * Get the corporate account record associated with the account.
     */
    public function corporate()
    {
        return $this->belongsTo('App\CustomerCorporate', 'account_id');
    }

     /**
     * Get the individual account record associated with the account.
     */
    public function individual()
    {
        return $this->belongsTo('App\CustomerIndividual', 'account_id');
    }

    protected $casts = [
        'cont' => 'array'
    ];
}
