<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressCustomer extends Model
{
    use SoftDeletes;
    
    protected $table = 'address_customer';

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function countryName()
    {
        return $this->belongsTo('App\Country', 'country','id');
    }

     public function stateName()
    {
        return $this->belongsTo('App\State', 'state','id');
    }

    public function cityName()
    {
        return $this->belongsTo('App\City', 'city','id');
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
