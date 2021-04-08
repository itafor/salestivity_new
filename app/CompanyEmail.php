<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    protected $fillable = ['company_detail_id', 'email','main_acct_id'];
    
}
