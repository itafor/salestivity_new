<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
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
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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

        $this->validate($request, [
            'name' => 'required|max:255|min:2',
            'category' => 'required',
            'type' => 'required|max:255',
            'notes' => 'required',
        ]);
        $product->name = $request->name;
        $product->category = $request->category;
        $product->type = $request->type;
        $product->notes = $request->notes;
        $product->save();


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
        $product = Product::find($id);
        return view('product.show', compact('product'));
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
            'category' => 'required',
            'type' => 'required|max:255',
            'notes' => 'required',
        ]);
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->type = $request->input('type');
        $product->notes = $request->input('notes');
        $product->save();


        $status = "Product has been updated successfully!!!";
        Session::flash('status', $status);

        return redirect()->route('product.show', $product->id);
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
