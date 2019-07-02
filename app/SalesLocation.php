<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesLocation extends Model
{
    protected $table = "sales_location";

    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

}
