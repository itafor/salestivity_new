<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerIndividual extends Model
{
    public function customer()
    {
        return $this->hasOne('App\Customer', 'account_id');
    }
}
