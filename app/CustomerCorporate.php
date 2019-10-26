<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCorporate extends Model
{
    use SoftDeletes;
    /**
     * Get the corporate account record associated with the account.
     */
    public function customer()
    {
        return $this->hasOne('App\Customer', 'account_id');
    }

    
}
