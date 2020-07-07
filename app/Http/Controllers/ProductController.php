<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;
use Session;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the main acct id from the logged in guard
        $userId = getActiveGuardType()->main_acct_id;
        $products = Product::orderBy('id', 'DESC')->where('main_acct_id', $userId)->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $userId = getActiveGuardType()->main_acct_id;
        $categories = Category::where('main_acct_id', $userId)->get();
        $subCategories = SubCategory::where('main_acct_id', $userId)->get();
        // dd($categories);
        return view('product.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        // // store the creator's id and main_acct_id
        // if(auth()->check()) {
        //     $main_acct_id = auth()->user()->id;
        //     $created_by = auth()->user()->id;
        //     $userType = 'users';
        // }
        // if(auth()->guard('sub_user')->check()) {
        //     // get the sub_user's main_acct_id
        //     $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
        //     $created_by = auth()->guard('sub_user')->user()->id;
        //     $userType = 'sub_users';
        // }
        $guard_object = \getActiveGuardType();
        $userId = $guard_object->main_acct_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required',
            'standard_price' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        // Attempt to store on the DB
        try {
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->description = $request->description;
            $product->standard_price = $request->standard_price;
            $product->main_acct_id = $guard_object->main_acct_id;
            $product->created_by = $guard_object->created_by;
            $product->user_type = $guard_object->user_type;
            $product->save();

        } catch (\Throwable $th) {
            Alert::error('Unable to save product');
            return back()->withInput();
        }
        
        Alert::success('Product', 'Product has been successfully added');
        return redirect()->route('product.index');

        // $cat = $request->category_id;
        //$product->category()->sync($cat);
        // $status = "New Product has been Added ";
        // Session::flash('status', $status);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = getActiveGuardType()->main_acct_id;
        $product = Product::where('id', $id)->where('main_acct_id', $userId)->latest()->first();
        // dd($product);
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('product.show', compact('product', 'categories', 'subCategories'));
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
        try {
            $product = Product::find($id);
    
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|min:2',
                'category_id' => 'required',
            ]);
    
            if($validator->fails()){
                Alert::warning('Product', 'Please fill all required fields');
                return back()->withInput();
            }
            // $this->validate($request, [
            //     'name' => 'required|max:255|min:2',
            //     'category_id' => 'required',
            // ]);
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->sub_category_id = $request->input('sub_category_id');
            $product->description = $request->input('description');
            $product->standard_price = $request->input('standard_price');
            $product->update();
    
    
            $status = "Product has been updated successfully!!!";
            Alert::success('Product', $status);
    
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Product', 'The process could not be completed');
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
        $product = Product::find($id);
        $product->delete();

        Alert::success('Project', 'The Product has been successfully deleted');
        return redirect()->route('product.index');
    }
}
