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
        'surname',
        'name',
        'phone',
        'email',
        'main_acct_id',
        'contact_type',
        'alternative_email'
    ];

    protected $casts = [
        'cont' => 'array'
    ];
    
    public function customer() {
        return $this->belongsTo('App\Customer','customer_id','id');
    }
}
