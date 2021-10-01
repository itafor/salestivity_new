<!doctype html>
<html>
<head>
<meta charset="utf-8">
<body>
<div class="invoice-box">
*Managed Hosting Invoice*
@if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin: auto; height: 140px; width: 150px; align-content: center;">
@endif

@if(isset($renewal->user))
<p>{{getCompanyName($renewal->user) }}</p>
@endif

Dear {{$renewal->customers->name}},
Please be informed that for the <strong>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}</strong> for <strong>{{ $renewal->customers->name }}</strong> is due for renewal
@if(isset($remaingDays) && $remaingDays >= 1)
    in <strong>{{$remaingDays}}</strong> days.
@else
.
@endif


Find below the details of the invoice. Kindly make payment before the due date to avoid service suspension. Please read the domain expiration information section below.


*Invoice Details*
@if(isset($renewal))
<b>{{ __('Item') }}</b>: {{ $renewal->prod ? $renewal->prod->name : 'N/A' }}

<b>{{ __('Invoice Number') }}</b>: {{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}
<b>{{ __('Domain Name') }}</b>: {{ $renewal->customers ? $renewal->customers->website : 'N/A' }}

@if($renewal->status == 'Paid')
<b>{{ __('Status') }}</b>: {{ $renewal->status }}

@elseif($renewal->status == 'Partly paid')
<b>{{ __('Status') }}</b>: {{ $renewal->status }}

@else
<b>{{ __('Status') }}</b>: {{ $renewal->status }}

@endif
<b>{{ __('Original Amount') }}</b>: N{{ number_format($renewal->productPrice,2) }}

<b>{{ __('Discount') }}</b>: {{ $renewal->discount ? $renewal->discount : 'N/A' }}

{{ __('Amount Due') }}</b>: N{{ number_format($renewal->billingBalance,2) }}

{{ __('Due Date') }}</b>: {{ date("jS F, Y", strtotime($renewal->end_date)) }}</td> 

<b>{{ __('Payment Method') }}</b>:
<td>Bank Transfer <br>
<strong>Account Name</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_name : 'N/A' }}, <br>
<strong>Account Number</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->account_number : 'N/A' }} ,<br>
<strong>Bank</strong>: {{$renewal->compBankAcct ? $renewal->compBankAcct->bank_name : 'N/A' }}

@else
<span>No matching records found</span>
@endif

<p>Thank you for your continuous patronage.<br>
@if(isset($renewal->user))
{{getCompanyName($renewal->user) }}
@endif
 Billing Team</p><br>
<p>Important Domain Expiration Information
Please note after the due date your domain name, website alongside emails and other services will stop working. Please endeavour to make payments before this date to avoid service interruptions.
</p>
<p>
Also note that when your domain expires without renewing, it enters a Grace Period of about 29 - 35 days within which renewals can be made with an additional $50.00 to the fees stated above.
</p>
<p>
After this period, if your domain is not renewed, it enters a Redemtion Grace Period. A period of another 42 days where the owner can claim the domain with additional $200 redemption fee.
</p>
<p>
After this period, your domain may now be released to the public for re-registration on a first come first served basis or may be *AUCTIONED OFF* to the highest bidder in a domain auction system.
</p>
<p>
To avoid losing your domain name to an auction or anybody else, ensure your domain name is renewed and is always active.
</p>
<p>
This invoice and the details specified is generated for the client or organization whose names appear on it. If you have received this invoice in error, kindly disregard the information and delete as appropriate.
</p>


</div>
</div>
</div>
</body>
</html>