<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpportunityUpdate extends Model
{
	use SoftDeletes;

    protected $fillable = ['opportunity_id','user_id','update_date','type','commments'];


    public function user(){
    	return $this->belongsTo(SubUser::class,'user_id','id');
    }

     public function opportunity(){
    	return $this->belongsTo(Opportunity::class,'opportunity_id','id')->orderBy('created_at','desc');
    }

    public function updateReplies(){
    	return $this->hasMany(OpportunityUpdateReply::class,'opportunity_update_id','id');
    }
}
