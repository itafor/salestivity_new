<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Target extends Model
{
    use SoftDeletes;
    public function salesPerson()
    {
        return $this->belongsTo('App\SubUser', 'sales_person_id');
    }

    public function dept()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function getName($id)
    {
        $sales = User::find($id);
        return $sales->name;
    }

    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    
    public function getType($id)
    {
        if($id == 1){
            return "Weekly";
        } elseif($id == 2){
            return "Monthly";
        } else{
            return "Yearly";
        }

    }

}
