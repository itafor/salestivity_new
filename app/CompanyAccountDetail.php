<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyAccountDetail extends Model
{
    protected $fillable = ['company_detail_id', 'bank_name', 'account_name', 'account_number','main_acct_id'];
    
}
