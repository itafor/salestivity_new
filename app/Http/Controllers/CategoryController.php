<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{

     public function __construct()
    {
        $this->middleware(['auth','mainuserVerified'])->except('homepage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = getActiveGuardType()->main_acct_id;
        $categories = Category::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        return view('product.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.category.create');
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
        if($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }
        try {
            $guard_object = getActiveGuardType();
            // store each new category that was added
            $category = new Category;
            $category->name = $request->name;
            $category->user_type = $guard_object->user_type;
            $category->created_by = $guard_object->created_by;
            $category->main_acct_id = $guard_object->main_acct_id;
            // dd($category);
            $category->save();
    
            $addNewCategory = new Category;
            if($request->addCategory) {
                foreach($request->addCategory as $addCategory)
                {
                    $addNewCategory->name = $addCategory;
                    $addNewCategory->created_by = $guard_object->created_by;
                    $addNewCategory->user_type = $guard_object->user_type;
                    $addNewCategory->main_acct_id = $guard_object->main_acct_id;
    
                    $addNewCategory->save();
                }
            }
        
        } catch (\Throwable $th) {
            Alert::error('Add Sub Category', 'The process could not be completed');
            return back()->withInput();
        }


        $status = "Category has been added successfully!!!";
        Alert::success('Add Sub Category', $status);
        return redirect()->route('product.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::find($id);
        try {
            $cat->delete();
        } catch (\Throwable $th) {
            Alert::error('Delete Category', 'The process could not be completed');
            return back()->withInput();
        }

        Alert::success('status', 'The Category has been successfully deleted');
        // return redirect()->route('product.subcategory.index');
        return back();
    }
}
