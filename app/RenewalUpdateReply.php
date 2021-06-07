<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RenewalUpdateReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['renewal_update_id','user_id','reply'];

     public function user(){
    	return $this->belongsTo(SubUser::class,'user_id','id');
    }

     public function renwal_update(){
    	return $this->belongsTo(RenewalUpdate::class,'renewal_update_id','id');
    }
}
