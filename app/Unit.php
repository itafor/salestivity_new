<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    public function dept()
    {
        return $this->belongsTo('App\Department', 'dept_id');
    }

    protected $fillable = [
        'name', 'head'
    ];
}
