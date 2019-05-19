<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use Session;

class SubCategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        // store each new category that was added
        $subcategory = new SubCategory;
        $subcategory->name = $request->name;

        if($request->addSubCategory) {
            foreach($request->addSubCategory as $addSubCategory)
            {
                $subcategory->name = $addSubCategory;
            }
        }

        $subcategory->save();

        $status = 'Sub Category has been created';
        Session::flash('status', $status);
        return redirect()->route('product.subcategory.create');
    }
}
