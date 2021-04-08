<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = ['main_acct_id', 'logo', 'name'];

    public function user(){
    	return $this->belongsTo(User::class, 'main_acct_id', 'id');
    }
}
