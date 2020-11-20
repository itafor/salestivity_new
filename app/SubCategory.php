<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name','category_id', 'user_type','created_by','main_acct_id'
    ];

    public function category()
    {
    	return $this->belongsTo(Category::class,'category_id','id');
    }


public static function createNew($data)
  {
  	 $guard_object = getActiveGuardType();
      $userId = $guard_object->created_by;

      foreach ($data['subcategories'] as $key => $subcategory) {
        $subcategory = self::create([
           'name' => $subcategory['name'],
           'category_id' => $data['category_id'],
           'user_type' => $guard_object->user_type,
           'created_by' => $guard_object->created_by,
           'main_acct_id' => $guard_object->main_acct_id,
        ]); 
      }

        return $subcategory;
    }

  public static function updateSubCategory($data)
    {

     $ad_subcategory  =  self::where([
            ['id', $data['adSubCategoryId'] ],
        ])->update([
           'category_id' => $data['category_id'],
           'name' => $data['name'],
           'description' =>  $data['description'],
        ]); 

        return $ad_subcategory;

    }
}
