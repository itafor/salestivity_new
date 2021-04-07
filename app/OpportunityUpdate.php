<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpportunityUpdate extends Model
{
	use SoftDeletes;

    protected $fillable = ['opportunity_id','user_id','update_date','type','commments'];
}
