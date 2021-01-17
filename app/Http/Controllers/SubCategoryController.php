<?php

namespace App\Http\Controllers;

use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = getActiveGuardType()->main_acct_id;
        $subCategories = SubCategory::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        return view('product.subcategory.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guard_object = getActiveGuardType();
        
        return view('product.subcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:50'
        // ]);
        // if($validator->fails()) {
        //     return back()->withInput()->withErrors($validator->errors());
        // }

        

        $ad_category = SubCategory::createNew($request->all());
       
       if($ad_category){
        $status = 'Sub Category has been created';
        Alert::success('Add Sub Category', $status);
        return redirect()->route('product.subcategory.index');
       

        } else {
            Alert::error('Add Sub Category', 'The process could not be completed');
            return back()->withInput();
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcat = SubCategory::find($id);
        try {
            $subcat->delete();
        } catch (\Throwable $th) {
            Alert::error('Delete Sub Category', 'The process could not be completed');
            return back()->withInput();
        }

        Alert::success('status', 'The Sub Category has been successfully deleted');
        // return redirect()->route('product.subcategory.index');
        return back();
    }

    public function getProdSubCategory($id)
{
   $prod_sub_categories =  SubCategory::where([
    ['category_id',$id],
    ['main_acct_id', getActiveGuardType()->main_acct_id],
   ])->orderBy('name','DESC')->get();
   return response()->json(['prod_sub_categories'=>$prod_sub_categories]);
} 

public function getProdBySubCategoryId($id)
{
   $products =  Product::where([
     ['sub_category_id',$id],
     ['main_acct_id', getActiveGuardType()->main_acct_id],
   ])->orderBy('name','DESC')->get();
   return response()->json(['products'=>$products]);
} 

}
