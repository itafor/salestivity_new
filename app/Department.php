<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    
    public function units()
    {
        return $this->hasMany('App\Unit', 'dept_id');
    }
}
