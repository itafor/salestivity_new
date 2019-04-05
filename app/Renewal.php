<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
