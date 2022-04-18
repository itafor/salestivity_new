<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product;
use App\Services\OrderService;
use App\SubCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
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
        return view('direct-sale.orders.lists', $data);
    }

     public function createOrder()
    {
    	  $data['products'] = Product::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();

        return view('direct-sale.orders.create', $data);
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

        return view('direct-sale.orders.edit', $data);
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

     public function inSale()
    {
    	 $orders = Session::get('orders');
        $orderOwner = Session::get('orderOwner');
        $customerInventories = Inventory::where([
            ['customer_id', $orderOwner->id],
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->get();
        return view('direct-sale.orders.insale', compact('orders','orderOwner','customerInventories'));
    }

        public function customerInsale(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
             'customer_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $orders = $this->orderService->customerInsale($input);

        if ($orders) {

            // $status = "Customer Purchase pattern fetched!";
            // Alert::success('Purchase pattern ', $status);

        
        Session::put('orders', $orders);


            return redirect()->route('order.insale');
        }

        Alert::error('Order', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }
}
