<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailMarketing extends Model
{
    use HasFactory;

    protected $fillable = ['main_acct_id', 'created_by', 'user_type' 'message'];


   public function user(){
   	return $this->belongsTo(User::class,'main_acct_id','id');
   }

   public function sendNewMessage($data){
   		$message = self::Insert([
   		'main_acct_id' => getActiveGuardType()->main_acct_id,
        'created_by' =>  getActiveGuardType()->created_by,
        'user_type' => getActiveGuardType()->user_type,
        'message' => $data['message'],
   		]);
   }
}
