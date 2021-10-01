<!doctype html>
<html>

<body>
<div class="invoice-box">
*Invoice Notification*

@if(isset($invoice->user) && $invoice->user->company_logo_url !='')
<img class="card-img-top" src="{{$invoice->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
@endif

@if(isset($invoice->user))
<p>{{getCompanyName($invoice->user) }}</p>
@endif

Dear {{$invoice->customers->name}}
Please be informed that for the {{ $invoice->prod ? $invoice->prod->name : 'N/A' }} for {{ $invoice->customers->name }} is due for payment.

Find below the details of the invoice. 

*Invoice Details*

@if(isset($invoice))

{{ __('Item') }}: {{ $invoice->prod ? $invoice->prod->name : 'N/A' }}

{{ __('Invoice Number') }}: {{ $invoice->invoice_number ? $invoice->invoice_number : 'N/A' }}


@if($invoice->status == 'Paid')

{{ __('Status') }}: {{ $invoice->status }}

@elseif($invoice->status == 'Partly paid')
{{ __('Status') }}: {{ $invoice->status }}

@else

{{ __('Status') }}: {{ $invoice->status }}

@endif

{{ __('Original Amount') }}: N{{ number_format($invoice->cost, 2) }}

{{ __('Discount') }}: {{ $invoice->discount ? $invoice->discount : 'N/A' }}

{{ __('Amount Due') }}: N{{ number_format($invoice->billingBalance,2) }}

{{ __('Due Date') }}: {{ date("jS F, Y", strtotime($invoice->due_date)) }}

{{ __('Payment Method') }}:
Bank Transfer
<strong>Account Name</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_name : 'N/A' }},<br>
<strong>Account Number</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->account_number : 'N/A' }} , <br>
<strong>Bank</strong>: {{$invoice->compBankAcct ? $invoice->compBankAcct->bank_name : 'N/A' }}

@else
<span>No matching records found</span>
@endif

<p>Thank you for your continuous patronage.</p>
<p><b>
	@if(isset($invoice->user))
<p>{{getCompanyName($invoice->user) }}</p>
@endif
</b>  Billing Team.</p>
</div>
</div>

</div>
</body>
</html>