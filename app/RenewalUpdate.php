<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalUpdate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['renewal_id','user_id','update_date','type','commments', 'bill_remark', 'bill_remark_payment_date'];


    public function user(){
    	return $this->belongsTo(SubUser::class,'user_id','id');
    }

     public function renewal(){
    	return $this->belongsTo(Renewal::class,'opportunity_id','id')->orderBy('created_at','desc');
    }

    public function updateReplies(){
    	return $this->hasMany(RenewalUpdateReply::class,'renewal_update_id','id');
    }
}
