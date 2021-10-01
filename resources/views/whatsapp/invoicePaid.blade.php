<!doctype html>
<html>
<body>
<div class="invoice-box">
@if(isset($paid_invoice->invoice->user) && $paid_invoice->invoice->user->company_logo_url !='')
<img class="card-img-top" src="{{$paid_invoice->invoice->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
*Confirmation of Payment*

@endif

@if(isset($paid_invoice->invoice->user))
<p>{{getCompanyName($paid_invoice->invoice->user) }}</p>
@endif


Dear {{$paid_invoice->customer->name}},<br>
<p>
This is to confirm receipt of the sum of <strong> N{{number_format($paid_invoice->amount_paid,2)}}</strong> for the <strong>{{$paid_invoice->invoice->prod ? $paid_invoice->invoice->prod->name : 'N/A'}}</strong> for <strong>{{ $paid_invoice->customer->name }}</strong>
<br/>
Please find details below;
</p>

*Invoice payment DETAILS*

@if(isset($paid_invoice))
{{ __('Product') }} : {{ $paid_invoice->invoice->prod ? $paid_invoice->invoice->prod->name : 'N/A' }}

<b>{{ __('Amount') }}</b> : N{{ number_format($paid_invoice->invoice->billingAmount,2) }}


<b>{{ __('Amount Paid') }}</b> : N{{ number_format($paid_invoice->invoice->amount_paid,2)}}

<b>{{ __('Payment Date') }}</b> : {{ date("jS F, Y", strtotime($paid_invoice->payment_date)) }}

<b>{{ __('Balance') }}</b> : N{{ number_format($paid_invoice->billingbalance,2) }}

<b>{{ __('Status') }}</b> : {{ $paid_invoice->invoice ? $paid_invoice->invoice->status : 'N/A' }}

@else
<span>No matching records found</span>
@endif

<span>Thank you for your continued patronage.</span>
<span><b>
	@if(isset($paid_invoice->invoice->user))
{{getCompanyName($paid_invoice->invoice->user) }}
@endif
</b> Billing Team</span>
</div>
</body>
</html>