<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name','amount','number_of_subusers','number_of_accounts','description'];


    public static function createNewPlan($data)
    {
     return  self::create([
            'name' => $data['name'],
            'amount' => $data['amount'],
            'number_of_subusers' => $data['number_of_subusers'],
            'number_of_accounts' => $data['number_of_accounts'],
            'description' => isset($data['description']) ? $data['description'] : null
        ]);
    }

     public static function upgradePlan($data)
    {
        $plan = self::findOrFail($data['plan_id']);
        if($plan){
            $plan->name = $data['name'];
            $plan->amount = $data['amount'];
            $plan->number_of_subusers = $data['number_of_subusers'];
            $plan->number_of_accounts = $data['number_of_accounts'];
            $plan->description = isset($data['description']) ? $data['description'] : null;
            $plan->save();
        return $plan;
        }
        
    }

}
