<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50'
        ]);
        if($validator->fails()) {
            // Alert::warning('Sub Category', 'Please fill the required field appropriately');
            return back()->withInput()->withErrors($validator->errors());
        }

        try {
            $guard_object = getActiveGuardType();
            $userId = $guard_object->created_by;
            $subcategory = new SubCategory;
            $subcategory->name = $request->name;
            $subcategory->user_type = $guard_object->user_type;
            $subcategory->created_by = $guard_object->created_by;
            $subcategory->main_acct_id = $guard_object->main_acct_id;
            // dd($subcategory);
            $subcategory->save();
            
            $addNewSubCategory = new SubCategory;
            
            // store each new category that was added
            if($request->addSubCategory) {
                foreach($request->addSubCategory as $addSubCategory)
                {
                    $addNewSubCategory->name = $addSubCategory;
                    $addNewSubCategory->user_type = $guard_object->user_type;
                    $addNewSubCategory->created_by = $guard_object->created_by;
                    $addNewSubCategory->main_acct_id = $guard_object->main_acct_id;
    
                }
                $addNewSubCategory->save();
            }
        } catch (\Throwable $th) {
            Alert::error('Add Sub Category', 'The process could not be completed');
            return back()->withInput();
        }

        $status = 'Sub Category has been created';
        Alert::success('Add Sub Category', $status);
        return redirect()->route('product.subcategory.index');
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
}
