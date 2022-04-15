<?php
namespace App\Services;

use App\Order;

/**
 * 
 */
class OrderService
{
	
	public function storeOrder($data)
	{
		$order = new Order();
		$order->main_acct_id = getActiveGuardType()->main_acct_id;
        $order->created_by_id =  getActiveGuardType()->created_by;
        $order->customer_id = $data['customer_id'];
        $order->category_id = $data['category_id'];
        $order->subcategory_id = $data['sub_category_id'];
        $order->product_id = $data['product_id'];
        $order->user_type = getActiveGuardType()->user_type;
        $order->save();
        return $order;
	}

	public function updateOrder($data)
	{
		$order = Order::findOrFail($data['order_id']);
		$order->main_acct_id = getActiveGuardType()->main_acct_id;
        $order->created_by_id =  getActiveGuardType()->created_by;
        $order->customer_id = $data['customer_id'];
        $order->category_id = $data['category_id'];
        $order->subcategory_id = $data['sub_category_id'];
        $order->product_id = $data['product_id'];
        $order->user_type = getActiveGuardType()->user_type;
        $order->save();
        return $order;
	}

	public function listOrders($order_id)
	{
		return Order::with(['user', 'customer', 'product', 'category', 'subCategory'])->get();
	}

	public function showOrder($order_id)
	{
	  return Order::where('id', $order_id)->with(['user', 'customer', 'product', 'category', 'subCategory'])->first();
	}

	public function deleteOrder($order_id)
	{
		return Order::findOrFail($order_id)->delete();
	}
}