<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function dept()
    {
        return $this->belongsTo('App\Department', 'dept_id');
    }

    protected $fillable = [
        'name', 'head'
    ];
}
