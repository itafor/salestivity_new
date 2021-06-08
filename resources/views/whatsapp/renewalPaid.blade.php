<!doctype html>
<html>
<head>
</head>

<body>
<div class="invoice-box">
*Renewal Payment Notifications*
@if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px;  align-content: center;">
<span style="margin: auto;"><b>{{$renewal->user->company_detail ? $renewal->user->company_detail->name : '' }}</b></span>
@endif

Dear {{$renewal->customer->name}},

This is to confirm receipt of the sum of <strong>N {{number_format($renewal->amount_paid,2)}}</strong> for the <strong>{{$renewal->product->name}}</strong> for <strong>{{ $renewal->customer->name }}</strong>
<br/>
Please find details below;

@if(isset($renewal))
<b>{{ __('Product') }}</b>: {{ $renewal->renewal->prod ? $renewal->renewal->prod->name : 'N/A' }}

<b>{{ __('Amount') }}</b>: N{{ number_format($renewal->renewal->billingAmount,2) }}

<b>{{ __('Amount Paid') }}</b>: N{{ number_format($renewal->renewal->amount_paid,2) }}

{{ __('Payment Date') }}</b>: {{ date("jS F, Y", strtotime($renewal->payment_date)) }}

<b>{{ __('Balance') }}</b>: N{{ number_format($renewal->billingbalance,2) }}


@if($payment_status->status == 'Paid')
<b>{{ __('Status') }}</b>: {{ $payment_status->status }}

@elseif($payment_status->status == 'Partly paid')
<b>{{ __('Status') }}</b>: {{ $payment_status->status }}
@else

<b>{{ __('Status') }}</b>: {{ $payment_status->status }}
@endif

@else
<span>No matching records found</span>
@endif

<p>Thank you for your continued patronage.</p>
<p><b>{{$renewal->user->company_detail ? $renewal->user->company_detail->name : '' }}</b> Billing Team</p>


</div>
</body>
</html>