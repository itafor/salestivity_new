<?php
namespace App\Services;

use App\Inventory;
use App\Order;

/**
 * 
 */
class OrderService
{
	
	public function storeOrder(array $data)
	{
		// return $data;
		$order = new Order();
		$order->main_acct_id = getActiveGuardType()->main_acct_id;
        $order->created_by_id =  getActiveGuardType()->created_by;
        $order->customer_id = $data['customer_id'];
        $order->category_id = $data['category_id'];
        $order->subcategory_id = $data['subcategory_id'];
        $order->product_id = $data['product_id'];
        $order->quantity = $data['quantity'];
        $order->user_type = getActiveGuardType()->user_type;
        $order->status = $data['status'];
        $order->save();

       $this->createOrderInventory($order);

        return $order;
	}

	// Add selested product and quatity in inventory
	public function createOrderInventory($order)
	{

	     $inventory = $this->getInventory($order->customer_id, $order->product_id);


		if($inventory)
		{
			$inventory->quantity += $order->quantity;
			$inventory->save();

		} else {

		$inventory = new Inventory();
		$inventory->main_acct_id = getActiveGuardType()->main_acct_id;
        $inventory->created_by_id =  getActiveGuardType()->created_by;
        $inventory->customer_id = $order->customer_id;
        $inventory->product_id = $order->product_id;
        $inventory->quantity = $order->quantity;
        $inventory->user_type = getActiveGuardType()->user_type;
        $inventory->status = 'In Stock';
        $inventory->save();
        return $inventory;
      }
	}

	public function updateOrder($data)
	{

		$oldOrder = Order::where([
			['id', $data['order_id']],
			['customer_id', $data['customer_id']],
			['product_id', $data['product_id']],
			['main_acct_id', getActiveGuardType()->main_acct_id],
		])->first();


	     // $inventory = $this->getInventory($data['customer_id'], $data['product_id']);

	     $inventory = Inventory::where([
			['customer_id', $data['customer_id']],
			['product_id', $data['product_id']],
			['main_acct_id', getActiveGuardType()->main_acct_id],
		])->first();

		if($oldOrder && $inventory)
		{
			$inventory->quantity -= $oldOrder->quantity;
			$inventory->save();

		} 

		$order = Order::findOrFail($data['order_id']);
		$order->main_acct_id = getActiveGuardType()->main_acct_id;
        $order->created_by_id =  getActiveGuardType()->created_by;
        $order->customer_id = $data['customer_id'];
        $order->category_id = $data['category_id'];
        $order->subcategory_id = $data['subcategory_id'];
        $order->product_id = $data['product_id'];
        $order->quantity = $data['quantity'];
        $order->user_type = getActiveGuardType()->user_type;
        $order->status = $data['status'];
        $order->save();

       if($oldOrder && $inventory)
		{
			$inventory->quantity += $data['quantity'];
            $inventory->status = $inventory->status <= 0 ? 'Out of Stock' : 'In Stock';
			$inventory->save();

		} 

        return $order;
	}

	public function listOrders()
	{
		return Order::with(['user', 'customer', 'product', 'category', 'subCategory'])->orderBy('created_at','desc')->get();
	}

	public function showOrder($orderId)
	{
	  return Order::where('id', $orderId)->with(['user', 'customer', 'product', 'category', 'subCategory'])->first();
	}

	public function deleteOrder($orderId)
	{
		$order = Order::findOrFail($orderId);

	     // $inventory = $this->getInventory($order->customer_id, $order->product_id);
		$inventory = Inventory::where([
			['customer_id', $order->customer_id],
			['product_id', $order->product_id],
			['main_acct_id', getActiveGuardType()->main_acct_id],
		])->first();

		if($inventory)
		{
			$inventory->quantity -= $order->quantity;
            $inventory->status = $inventory->quantity <= 0 ? 'Out of Stock' : 'In Stock';
			$inventory->save();

		}

		$order->delete();

		return $order;
	}

	public function getInventory($customerId, $productId)
	{
		$inventory = Inventory::where([
			['customer_id', $customerId],
			['product_id', $productId],
			['main_acct_id', getActiveGuardType()->main_acct_id],
		])->first();

	}
}