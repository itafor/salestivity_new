<?php

namespace App\Http\Controllers;

use App\CurrencySymbol;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['currencies'] = CurrencySymbol::all();
        return view('currency.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currency = new CurrencySymbol();
        $currency->symbol = $request->currency_symbol;
        $currency->description = $request->description;
        $currency->save();
        return redirect()->back()->withStatus(__('New currency symbol added successfully'));
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
         $data['currency'] = CurrencySymbol::findOrFail($id);
         // dd($data['currency']);
        return view('currency.edit', $data);
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
        $currency = CurrencySymbol::findOrFail($id);
        $currency->symbol = $request->currency_symbol;
        $currency->description = $request->description;
        $currency->save();
        return redirect()->back()->withStatus(__('Currency symbol updated successfully'));

    }

       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCurrency(Request $request)
    {
        $currency = CurrencySymbol::findOrFail($request->id);
        dd($currency);
        $currency->symbol = $request->currency_symbol;
        $currency->description = $request->description;
        $currency->save();
        return redirect()->back()->withStatus(__('Currency symbol updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $currency = CurrencySymbol::findOrFail($id);
         if($currency){
            $currency->delete();
        return redirect()->back()->withStatus(__('Currency symbol deleted successfully'));
         }
    }
}
