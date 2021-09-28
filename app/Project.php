<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * Create one to many relationship between Customer and Project
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_account');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

     public function getTechnician()
    {
        return $this->belongsTo('App\SubUser', 'technician_id');
    }
}
