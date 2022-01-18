<?php
namespace App\Http\Services\Billing;

use App\InvoiceProduct;
/**
 * 
 */
class BillingInvoiceServices
{
	//Store all product attashed to this invoice
	public function storeInvoiceProducts($data, $invoice)
	{
		if(isset($data['products']))
   {
        foreach($data['products'] as $product){
            InvoiceProduct::create([
                'billing_invoice_id' => $invoice->id,
                'product_id' => $product['product_id'],
              
            ]);
        }
    }
	}
}
