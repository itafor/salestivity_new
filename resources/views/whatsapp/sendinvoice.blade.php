<!doctype html>
<html>

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
<td style="width: 150px;"><b>{{ __('Original Amount') }}</b></td>
<td> N {{ number_format($invoice->cost, 2) }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Discount') }}</b></td>
<td>{{ $invoice->discount ? $invoice->discount : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Amount Due') }}</b></td>
<td>N{{ number_format($invoice->billingBalance,2) }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Due Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($invoice->due_date)) }}</td>           
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Payment Method') }}</b></td>
<td>Bank Transfer <br>
<strong>Account Name</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_name : 'N/A' }},<br>
<strong>Account Number</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_number : 'N/A' }} , <br>
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