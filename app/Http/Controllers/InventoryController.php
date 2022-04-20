<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\ProductReview;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    public function getInventoryToManage($inventoryId)
    {
    	$inventory =$this->getOneInventory($inventoryId);

    	return response()->json(['inventory'=>$inventory], 200);
    }

    public function updateInventory(Request $request)
    {
    	$data = $request->all();
    	$inventory = Inventory::where([
    		['id', $data['inventory_id']],
    		['main_acct_id', getActiveGuardType()->main_acct_id]
    	])->first();

    	if($inventory){
    		$inventory->quantity = $data['quantity'];
    		$inventory->save();

    		 $status = "Inventory updated successfully!";
               Alert::success('Inventory', $status);
               return back();
            }
    	}

    public function showInventory($inventoryId)
    {
      $data['inventory'] = $this->getOneInventory($inventoryId);

      $data['reviews'] = ProductReview::where([
            ['inventory_id', $inventoryId],
            ['user_id', getActiveGuardType()->main_acct_id]
        ])->orderBy('created_at', 'desc')->paginate(5);


        return view('direct-sale.inventory.show', $data);
    }

    public function getOneInventory($inventoryId)
    {
   return   $inventory = Inventory::where([
            ['id', $inventoryId],
            ['main_acct_id', getActiveGuardType()->main_acct_id]
        ])->with(['user', 'customer', 'product'])->first();
    }
}

