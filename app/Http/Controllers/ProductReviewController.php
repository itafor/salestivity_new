<?php

namespace App\Http\Controllers;

use App\Services\ProductReviewService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class ProductReviewController extends Controller
{
    public $productReviewService;

	function __construct(ProductReviewService $productReviewService)
	{
        $this->middleware(['auth','mainuserVerified','subuserVerified']);

		$this->productReviewService = $productReviewService;
	}



       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReview(Request $request)
    {

    	$input = $request->all();
// dd($input);
        $validator = Validator::make($input, [
        	 'inventory_id' => 'required|numeric',
        	 'product_id' => 'required|numeric',
        	 'attribute' => 'required|string',
        	 'comment' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // dd($validator);
        $review = $this->productReviewService->storeReview($input);

        if ($review) {

            $status = "Product reviewed successfully!";
            Alert::success('Product Review', $status);

            return back();
        }

        Alert::error('Product Review', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

   

    

        public function updateReview(Request $request)
    {

    	$input = $request->all();

        $validator = Validator::make($input, [
        	 'review_id' => 'required|numeric',
        	 'review_inventory_id' => 'required|numeric',
        	 'review_product_id' => 'required|numeric',
        	 'review_attribute' => 'required|string',
        	 'review_comment' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // dd($validator);
        $review = $this->productReviewService->updateReview($input);

        if ($review) {

            $status = "Review updated successfully!";
            Alert::success('Product Review Update', $status);

            return back();
        }

        Alert::error('Product Review Update', 'This action could not be completed');
        return back()->withInput()->withErrors($validator);
    }

    public function deleteReview($reviewId)
    {
    	  $this->productReviewService->deleteReview($reviewId);

    	    $status = "Review deleted successfully!";
            Alert::success('Product Review', $status);

            return back();
    }
}
