<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice  Notification</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        /*border: 1px solid #eee;*/
        /*box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    #rental_table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

#rental_table td{
  border: 1px solid #ddd;
  padding: 8px;
}
#rental_table .rent_title{
  width: 150px;
}

    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .notification_header{
            font-size: 10px;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
       <h2>Invoice Notification</h2>

<div class="card">
<div class="card-body">
    @if(isset($invoice->user) && $invoice->user->company_logo_url !='')
<img class="card-img-top" src="{{$invoice->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
<p>{{$invoice->user->company_detail ? $invoice->user->company_detail->name : '' }}</p>
@endif

<p class="card-text">Dear {{$invoice->customers->name}},</p>
<p>Please be informed that for the <strong>{{ $invoice->prod ? $invoice->prod->name : 'N/A' }}</strong> for <strong>{{ $invoice->customers->name }}</strong> is due for payment.
</p>
<p>
Find below the details of the invoice. 
</p>
<h4>Invoice Details</h4>
<table class="table table-bordered" id="rental_table">
@if(isset($invoice))
<tbody>
<tr>
<td style="width: 150px;"><b>{{ __('Item') }}</b></td>
<td>{{ $invoice->prod ? $invoice->prod->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Invoice Number') }}</b></td>
<td>{{ $invoice->invoice_number ? $invoice->invoice_number : 'N/A' }}
</td>
</tr>
@if($invoice->status == 'Paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-success">{{ $invoice->status }}
</td>
</tr>
@elseif($invoice->status == 'Partly paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-warning">
{{ $invoice->status }}
</td>
</tr>
@else
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-danger">
{{ $invoice->status }}
</td>
</tr>
@endif
<tr>
<td style="width: 150px;"><b>{{ __('Amount Due') }}</b></td>
<td>&#8358;{{ number_format($invoice->billingBalance,2) }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Due Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($invoice->due_date)) }}</td>           
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Payment Method') }}</b></td>
<td>Bank Transfer &nbsp; <br>
<strong>Account Name</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_name : 'N/A' }}, &nbsp;<br>
<strong>Account Number</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_number : 'N/A' }} , &nbsp;<br>
<strong>Bank</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->bank_name : 'N/A' }}
</td>           
</tr>
</tbody>
@else
<span>No matching records found</span>
@endif
</table>
<p>Thank you for your continuous patronage.</p>
<p><b>{{$invoice->user->company_detail ? $invoice->user->company_detail->name : '' }}</b>  Billing Team.</p>
</div>
</div>

    </div>
</body>
</html>