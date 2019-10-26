<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renewal extends Model
{
    use SoftDeletes;
    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function payments()
    {
        return $this->morphToMany('App\Payment', 'payable');
    }
}
