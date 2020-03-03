<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\SubCategory;
use Session;

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
        $userId = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255|min:2',
            'category_id' => 'required'
        ]);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->description = $request->description;
        $product->standard_price = $request->standard_price;
        $product->main_acct_id = $userId;
        $product->save();

        // $cat = $request->category_id;

        //$product->category()->sync($cat);


        $status = "New Product has been Added ";
        Session::flash('status', $status);

        return redirect()->route('product.index');
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
