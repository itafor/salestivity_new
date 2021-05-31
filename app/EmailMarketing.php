<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailMarketing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['main_acct_id', 'created_by', 'user_type', 'message', 'subject'];


   public function user(){
   	return $this->belongsTo(User::class,'main_acct_id','id');
   }

   public static function newMessage($data){
   		$message = self::create([
   		'main_acct_id' => getActiveGuardType()->main_acct_id,
        'created_by' =>  getActiveGuardType()->created_by,
        'user_type' => getActiveGuardType()->user_type,
        'subject' => $data['subject'],
        'message' => $data['message'],
   		]);

       return $message;
   }
}
