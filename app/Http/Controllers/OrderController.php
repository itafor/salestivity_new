<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\OrderService;
use App\SubCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class OrderController extends Controller
{

	public $orderService;

	function __construct(OrderService $orderService)
	{
        $this->middleware(['auth','mainuserVerified','subuserVerified']);

		$this->orderService = $orderService;
	}

     public function listOrders()
    {
        $data['orders'] = $this->orderService->listOrders();
        return view('orders.lists', $data);
    }

     public function createOrder()
    {
    	  $data['products'] = Product::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        return view('orders.create', $data);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(Request $request)
    {

    	$input = $request->all();

        $validator = Validator::make($input, [
        	 'customer_id' => 'required|numeric',
        	 'category_id' => 'required|numeric',
        	 'subcategory_id' => 'required|numeric',
        	 'product_id' => 'required|numeric',
        	 'quantity' => 'required|numeric',
        	 'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $order = $this->orderService->storeOrder($input);

        if ($order) {

            $status = "New Order created successfully!";
            Alert::success('Order', $status);

            return redirect()->route('order.lists');
        }

        Alert::error('Order', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

      public function editOrder($orderId)
    {
    	  $data['products'] = Product::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

      $data['order'] = $this->orderService->showOrder($orderId);

      $data['subcategory'] = SubCategory::findOrFail($data['order']->subcategory_id);

        return view('orders.edit', $data);
    }

       public function updateOrder(Request $request)
    {

    	$input = $request->all();

        $validator = Validator::make($input, [
        	 'order_id' => 'required|numeric',
        	 'customer_id' => 'required|numeric',
        	 'category_id' => 'required|numeric',
        	 'subcategory_id' => 'required|numeric',
        	 'product_id' => 'required|numeric',
        	 'quantity' => 'required|numeric',
        	 'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $order = $this->orderService->updateOrder($input);

        if ($order) {

            $status = "Order updated successfully!";
            Alert::success('Order', $status);

            return redirect()->route('order.lists');
        }

        Alert::error('Order', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

    public function deleteOrder($orderId)
    {
    	  $order = $this->orderService->deleteOrder($orderId);

    	    $status = "Order deleted successfully!";
            Alert::success('Order', $status);

            return redirect()->route('order.lists');
    }
}
