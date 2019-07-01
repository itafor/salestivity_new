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

    public function getCountry($id)
    {
        $country = Country::where('id',$id)->first();
        return $country->country_name;
    }

    public function getState($id)
    {
        $state = State::where('id',$id)->first();
        return $state->name;
    }

    public function getCity($id)
    {
        $city = City::where('id',$id)->first();
        return $city->name;
    }

}
