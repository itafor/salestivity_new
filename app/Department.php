<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function units()
    {
        return $this->hasMany('App\Unit', 'dept_id');
    }
}
