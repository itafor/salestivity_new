<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function payments()
    {
        return $this->morphToMany('App\Payment', 'payable');
    }
}
