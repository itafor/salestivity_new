@component('mail::message')
# Invoice Renewal Notification
@if(isset($customerRenewal->user) && $customerRenewal->user->company_logo !='')
<img src="{{asset('uploads/'.$customerRenewal->user->company_logo)}}" alt="company logo" width="100" height="100">
@endif
<br>
Dear {{$customerContact->name}},<br>
<em>
@if($remaing_days <= 0)
Kindly be notified that your renewal has expired.<br>
Expired Date: ( {{ date("jS F, Y", strtotime($customerRenewal->end_date)) }} )
@else
Kindly be notified that your renewal will be due on 
{{ date("jS F, Y", strtotime($customerRenewal->end_date)) }}.
@endif
<br/>
Please find below Recurring details.
</em>
<!-- @component('mail::button', ['url' => ''])
Renew Now
@endcomponent -->
<h4>Invoice Details</h4>
<table class="table table-bordered">
@if(isset($customerRenewal))
<tbody>
<tr>
<td style="width: 120px;"><b>{{ __('Customer') }}</b></td>
<td>{{ $customerRenewal->customers->name }}</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Category') }}</b></td>
<td>{{ $customerRenewal->category ? $customerRenewal->category->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Sub Category') }}</b></td>
<td>{{ $customerRenewal->subcategory ? $customerRenewal->subcategory->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Product') }}</b></td>
<td>{{ $customerRenewal->prod ? $customerRenewal->prod->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Billing Amount') }}</b></td>
<td>&#8358;{{ number_format($customerRenewal->billingAmount,2) }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Billing Balance') }}</b></td>
<td>&#8358;{{ number_format($customerRenewal->billingBalance,2) }}
</td>
</tr>
@if($customerRenewal->status == 'Paid')
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-success">{{ $customerRenewal->status }}
</td>
</tr>
@elseif($customerRenewal->status == 'Partly paid')
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-warning">
{{ $customerRenewal->status }}
</td>
</tr>
@else
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-danger">
{{ $customerRenewal->status }}
</td>
</tr>
@endif
<tr>
<td style="width: 120px;"><b>{{ __('Start Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($customerRenewal->start_date)) }}</td>           
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('End Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($customerRenewal->end_date)) }}</td>           
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Date created') }}</b></td>
<td>{{ date("jS F, Y", strtotime($customerRenewal->created_at)) }}</td>           
</tr>
</tbody>
@else
<span>No matching records found</span>
@endif
</table>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
