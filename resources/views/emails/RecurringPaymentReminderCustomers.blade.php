@component('mail::message')
# Invoice Renewal Notification
@if(isset($renewal->user) && $renewal->user->company_logo !='')
<img src="{{asset('uploads/'.$renewal->user->company_logo)}}" alt="company logo" width="50" height="40">
@endif
Dear {{$renewal->customers->name}},<br><br>
<em>
@if($remaingDays <= 0)
Kindly be notified that your Recurring has expired.<br>
Expired Date:
{{ date("jS F, Y", strtotime($renewal->end_date)) }} 
@else
Kindly be notified that your Recurring will be due on
{{ date("jS F, Y", strtotime($renewal->end_date)) }}.
@endif
<br/>
Please find below Recurring details.
</em>
<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->
<h4>Invoice Details</h4>
<table class="table table-bordered">
@if(isset($renewal))
<tbody>
<tr>
<td style="width: 120px;"><b>{{ __('Customer') }}</b></td>
<td>{{ $renewal->customers->name }}</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Category') }}</b></td>
<td>{{ $renewal->category ? $renewal->category->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Sub Category') }}</b></td>
<td>{{ $renewal->subcategory ? $renewal->subcategory->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Product') }}</b></td>
<td>{{ $renewal->prod ? $renewal->prod->name : 'N/A' }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Billing Amount') }}</b></td>
<td>&#8358;{{ number_format($renewal->billingAmount,2) }}
</td>
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('Billing Balance') }}</b></td>
<td>&#8358;{{ number_format($renewal->billingBalance,2) }}
</td>
</tr>
@if($renewal->status == 'Paid')
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-success">{{ $renewal->status }}
</td>
</tr>
@elseif($renewal->status == 'Partly paid')
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-warning">
{{ $renewal->status }}
</td>
</tr>
@else
<tr>
<td style="width: 120px;"><b>{{ __('Status') }}</b></td>
<td class="text-danger">
{{ $renewal->status }}
</td>
</tr>
@endif
<tr>
<td style="width: 120px;"><b>{{ __('Start Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($renewal->start_date)) }}</td>           
</tr>
<tr>
<td style="width: 120px;"><b>{{ __('End Date') }}</b></td>
<td>{{ date("jS F, Y", strtotime($renewal->end_date)) }}</td>           
</tr>
</tbody>
@else
<span>No matching records found</span>
@endif
</table>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
