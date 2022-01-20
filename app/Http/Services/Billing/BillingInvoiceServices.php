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

   public function updateInvoiceProducts($data, $invoice)
    {
 if(isset($data['editableproducts']))
   {
        foreach($data['editableproducts'] as $product){
           $prodInvoice = InvoiceProduct::where([
                ['billing_invoice_id', $invoice->id],
                ['product_id', $product['product_id']],
            ])->first();

                $prodInvoice->billing_invoice_id = $invoice->id;
                $prodInvoice->product_id = $product['product_id'];
              $prodInvoice->save();
            
        }
    }
    $this->storeInvoiceProducts($data, $invoice);
    }

}
