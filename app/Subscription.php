<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

      protected $fillable = [
         'user_id', 'transaction_id', 'start_date', 'end_date', 'reference','plan_id','channel','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public static function upgradePlan($data)
    {
    	 return self::create([
            'user_id' => getActiveGuardType()->main_acct_id,
            'reference' => generateUUID(),
            'plan_id' => $data['plan_id'],
            'status' => $data['status'],
            'channel' => 'Bank Transfer'
        ]);
    }
}
