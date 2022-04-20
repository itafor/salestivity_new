<?php
namespace App\Services;

use App\ProductReview;


class ProductReviewService
{
	
  public function storeReview(array $data)
	{
		// return $data;
		$review = new ProductReview();
		$review->user_id = getActiveGuardType()->main_acct_id;
        $review->created_by_id =  getActiveGuardType()->created_by;
        $review->product_id = $data['product_id'];
        $review->inventory_id = $data['inventory_id'];
        $review->attribute = $data['attribute'];
        $review->comment = $data['comment'];
        $review->user_type = getActiveGuardType()->user_type;
        $review->save();

        return $review;
	}	

	public function updateReview(array $data)
	{
		
		$review = ProductReview::where([
			['id', $data['review_id']],
			['product_id', $data['review_product_id']],
			['user_id', getActiveGuardType()->main_acct_id],
		])->first();

	   if($review){
		$review->user_id = getActiveGuardType()->main_acct_id;
        $review->created_by_id =  getActiveGuardType()->created_by;
        $review->product_id = $data['review_product_id'];
        $review->inventory_id = $data['review_inventory_id'];
        $review->attribute = $data['review_attribute'];
        $review->comment = $data['review_comment'];
        $review->user_type = getActiveGuardType()->user_type;
        $review->save();

        return $review;
		}
	}

	

	public function deleteReview($reviewId)
	{
		$review = ProductReview::findOrFail($reviewId);

		$review->delete();

		return $review;
	}
}