<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'title',

    ];

    protected $casts = [
        'cont' => 'array'
    ];
}
