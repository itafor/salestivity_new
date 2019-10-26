<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RetailFieldSale extends Model
{
    use SoftDeletes;
    
    public function getName($id)
    {
        $sales = User::find($id);
        return $sales->name;
    }
    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo('App\User', 'sales_person_id');
    }

    public function location()
    {
        return $this->belongsTo('App\SalesLocation', 'location_id');
    }
}
