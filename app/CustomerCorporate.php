<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerCorporate extends Model
{
    /**
     * Get the corporate account record associated with the account.
     */
    public function customer()
    {
        return $this->hasOne('App\Customer', 'account_id');
    }

    
}
