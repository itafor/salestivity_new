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

//update invoice products by deleting the existing invoices and recreating them
   public function updateInvoiceProducts($data, $invoice)
    {
 if(isset($data['editableproducts']))
   {

    $prodInvoices = InvoiceProduct::where([
                ['billing_invoice_id', $invoice->id],
            ])->get();
        if($prodInvoices){
    foreach ($prodInvoices as $key => $value) {
              $value->delete();
            }
        }

        foreach($data['editableproducts'] as $product){
            InvoiceProduct::create([
                'billing_invoice_id' => $invoice->id,
                'product_id' => $product['product_id'],
            ]);
        }
    }

    $this->storeInvoiceProducts($data, $invoice);
    }

}
