<?php 
namespace App\Http\Traits;

use App\Http\Controllers\CronJobController;
use App\Invoice;
use App\Mail\ConfirmInvoiceRecceipt;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;


trait InvoiceBillStatus{

	public function confirmInvoiceReceipt($invoice_id){
    $invoice = Invoice::find($invoice_id);

    if($invoice->bill_status == 'Confirmed'){
        return 'Already confirmed!!';
    }else{

        self::update_invoice_bill_status_to_confirmed($invoice);

           $toEmail = $invoice->user->email;

        Mail::to($toEmail)->send(new ConfirmInvoiceRecceipt($invoice));

        return 'Confirmed successfully!!';

    }
}

public static function update_invoice_bill_status_to_confirmed($invoice){
    $invoice = Invoice::find($invoice->id);
    $invoice->bill_status = 'Confirmed';
    $invoice->save();
}

   public function changeInvoiceBillStatusToConfirmed($invoice_id){
        $invoice = Invoice::find($invoice_id);

        if($invoice->bill_status == 'Confirmed'){
             Alert::success('Bill Status', 'Bill status already changed to confirmed');
    return redirect()->route('billing.invoice.show',$invoice_id);
        }else{

           self::update_invoice_bill_status_to_confirmed($invoice);

             Alert::success('Bill Status', 'Bill status changed to confirmed!!');
    return redirect()->route('billing.invoice.show',$invoice_id);
        }
}

  public function changeInvoiceBillStatusToSent($invoice_id){
        $invoice = Invoice::find($invoice_id);
        // dd($invoice);
        if($invoice->bill_status == 'Sent'){
             Alert::success('Bill Status', 'Bill status already changed to sent');
    return redirect()->route('billing.invoice.show',$invoice_id);
        }else{

            self::update_invoice_bill_status_to_sent($invoice);

             Alert::success('Bill Status', 'Bill status changed to sent!!');
    return redirect()->route('billing.invoice.show',$invoice_id);
        }
}



}