<?php

namespace App;

use App\OpportunityUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpportunityUpdateReply extends Model
{
    use SoftDeletes;

    protected $fillable = ['opportunity_update_id','user_id','reply'];

     public function user(){
    	return $this->belongsTo(SubUser::class,'user_id','id');
    }

     public function opport_update(){
    	return $this->belongsTo(OpportunityUpdate::class,'opportunity_update_id','id');
    }
}
