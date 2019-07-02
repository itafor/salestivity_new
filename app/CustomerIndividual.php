<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerIndividual extends Model
{
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
