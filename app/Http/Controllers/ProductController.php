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
        $userId = auth()->user()->id;
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
        $userId = auth()->user()->id;
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

        // store the creator's id and main_acct_id
        if(auth()->check()) {
            $main_acct_id = auth()->user()->id;
            $created_by = auth()->user()->id;
            $userType = 'users';
        }
        if(auth()->guard('sub_user')->check()) {
            // get the sub_user's main_acct_id
            $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
            $created_by = auth()->guard('sub_user')->user()->id;
            $userType = 'sub_users';
        }
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:2',
            'category_id' => 'required'
        ]);
        // $this->validate($request, [
        //     'name' => 'required|max:255|min:2',
        //     'category_id' => 'required'
        // ]);

        if ($validator->fails()) {
            Alert::warning('Required Fields', 'Please fill in a required fields');
            return back()->withInput();
        }
        try {
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->description = $request->description;
            $product->standard_price = $request->standard_price;
            $product->main_acct_id = $main_acct_id;
            $product->created_by = $created_by;
            $product->user_type = $userType;
            $product->save();

            Alert::success('Product', 'Product has been successfully added');
            return redirect()->route('product.index');
        } catch (\Throwable $th) {
            Alert::error('Unable to save product');
            return back()->withInput();
        }
        

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
        $userId = auth()->user()->id;
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
        $product = Product::find($id);

        $this->validate($request, [
            'name' => 'required|max:255|min:2',
            'category_id' => 'required',
        ]);
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->sub_category_id = $request->input('sub_category_id');
        $product->description = $request->input('description');
        $product->standard_price = $request->input('standard_price');
        $product->update();


        $status = "Product has been updated successfully!!!";
        Session::flash('status', $status);

        return redirect()->route('product.index');
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

        Session::flash('status', 'The Product has been successfully deleted');
        return redirect()->route('product.index');
    }
}
