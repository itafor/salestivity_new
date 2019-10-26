<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerIndividual extends Model
{
    use SoftDeletes;
    
    public function customer()
    {
        return $this->hasOne('App\Customer', 'account_id');
    }

    public function getIndustry($id)
    {
        $industry = Industry::where('id', $id)->first();
        return $industry->name;
    }
}
