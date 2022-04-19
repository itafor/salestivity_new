<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    public function getInventoryToManage($InventoryId)
    {
    	$inventory = Inventory::where([
    		['id', $InventoryId],
    		['main_acct_id', getActiveGuardType()->main_acct_id]
    	])->with(['user', 'customer', 'product'])->first();

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
    }

