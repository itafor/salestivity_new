@component('mail::message')
# Invoice Renewal Notification
<br>
<div class="card">
  @if(isset($renewal->user) && $renewal->user->company_logo_url !='')
<img class="card-img-top" src="{{$renewal->user->company_logo_url}}" alt="company logo" style="margin-left: 200px; height: 140px; width: 150px; border-radius: 50px;">
@endif
<br>
<br>
  <div class="card-body">
    <p class="card-text">Dear {{$renewal->customers->name}},</p>
    <p>Please be informed that for the <strong>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}</strong> for <strong>{{ $renewal->customers->name }}</strong> is due for renewal.</p>
<p>
Find below the details of the invoice. Kindly make payment before the due date to avoid service suspension. Please read the domain expiration information section below.
</p>
<h4>Invoice Details</h4>
<table class="table table-bordered">
@if(isset($renewal))
<tbody>
<tr>
<td style="width: 150px;"><b>{{ __('Customer') }}</b></td>
<td>{{ $renewal->customers->name }}</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Item') }}</b></td>
<td>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Invoice Number') }}</b></td>
<td>{{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}<td>
</td>
</tr>
@if($renewal->status == 'Paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-success">{{ $renewal->status }}
</td>
</tr>
@elseif($renewal->status == 'Partly paid')
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-warning">
{{ $renewal->status }}
</td>
</tr>
@else
<tr>
<td style="width: 150px;"><b>{{ __('Status') }}</b></td>
<td class="text-danger">
{{ $renewal->status }}
</td>
</tr>
@endif
<tr>
<td style="width: 150px;"><b>{{ __('Amount Due') }}</b></td>
<td>&#8358;{{ number_format($renewal->billingBalance,2) }}
</td>
</tr>
<tr>
<td style="width: 150px;"><b>{{ __('Payment Method') }}</b></td>
<td>Bank Transfer 
Digitalweb Application Development Limited
0044102222
Access Bank
</td>           
</tr>
</tbody>
@else
<span>No matching records found</span>
@endif
</table>
<p>Thank you for your continuous patronage.<br>
Digitalweb Billing Team</p><br>
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
After this period, your domain may now be released to the public for re-registration on a first come first served basis or may be *AUCTIONED OFF** to the highest bidder in a domain auction system.
</p>
<p>
To avoid losing your domain name to an auction or anybody else, ensure your domain name is renewed and is always active.
</p>
<p>
This invoice and the details specified is generated for the client or organization whose names appear on it. If you have received this invoice in error, kindly disregard the information and delete as appropriate.
</p>
  </div>
</div>
@endcomponent