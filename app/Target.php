<?php

namespace App;

use App\TargetProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Target extends Model
{
    use SoftDeletes;

    protected $fillable = ['sales', 'manager', 'main_acct_id', 'created_by','user_type','start_date','end_date','sales_person_id'];

    public function salesPerson()
    {
        return $this->belongsTo('App\SubUser', 'sales_person_id');
    }

    public function lineManager()
    {
        return $this->belongsTo('App\SubUser', 'manager');
    }

    // public function dept()
    // {
    //     return $this->belongsTo('App\Department', 'department_id');
    // }

    // public function unit()
    // {
    //     return $this->belongsTo('App\Unit', 'unit_id','id');
    // }

    // public function getName($id)
    // {
    //     $sales = User::find($id);
    //     return $sales->name;
    // }

    public function products()
    {
        return $this->hasMany('App\TargetProduct', 'target_id');
    }
    
   public static function buildNewTarget($data){

    $target = self::create([
        'main_acct_id' => getActiveGuardType()->main_acct_id,
        'user_type' => getActiveGuardType()->user_type,
        'created_by' => getActiveGuardType()->created_by,
        'sales_person_id' => $data['sales'],
        'manager' => $data['manager'],
        'start_date' => Carbon::parse(formatDate($data['start_date'], 'd/m/Y', 'Y-m-d')),
        'end_date' => Carbon::parse(formatDate($data['end_date'], 'd/m/Y', 'Y-m-d')),
    ]);

     return $target;

   }

    public static function add_target_products($target,$product) {

       $targetProd = new TargetProduct();
       $targetProd->target_id = $target->id;
       $targetProd->product_id = $product['product_id'];
       $targetProd->unit_price = $product['unit_price'];
       $targetProd->quantity = $product['quantity'];
       $targetProd->amount = $product['unit_price'] * $product['quantity']; 
       $targetProd->category_id = $product['category_id'];
       $targetProd->sub_category_id = $product['sub_category_id'];
       $targetProd->save();
    
return $targetProd;
 }

}
