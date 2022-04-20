@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('status') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="table-responsive">

<table class="table  table-bordered invoices" style="width:100%" >
<thead>
<tr>
    <th scope="col">{{ __('End Date') }}</th>
    <th class="word-wrap" scope="col">{{ __('Customer') }}</th>
    <th scope="col">{{ __('Product') }}</th>
    <th scope="col">{{ __('Amount') }}</th>
    <th scope="col">{{ __('Status') }}</th>
    <th scope="col">{{ __('Phone Number') }}</th>
    <th scope="col">{{ __('Action') }}</th>
</tr>
</thead>
<tbody>
@if($invoices->isEmpty())
    <tr>
        <td colspan="7" style="text-align: center">
            <h3>No data available</h3>
        </td>
    </tr>
@else
    @foreach($invoices as $invoice)
                          <?php   
                            $currentStatus= "";
                            if(isset($invoice)){
                            if($invoice->status == 'Partly paid'){
                            $currentStatus = "partly_paid";
                            }elseif($invoice->status == 'Pending'){
                            $currentStatus = "outstanding";
                            }elseif($invoice->status == 'Paid'){
                            $currentStatus = "paid";
                            }else{
                            $currentStatus = "all";
                            }
                            }
                            ?>
        <tr>
         <td>
            {{ $invoice->due_date ? date('Y/m/d', strtotime($invoice->due_date)) : 'N/A' }}
            </td>
            <td class="word-wrap">{{ $invoice->customers ? $invoice->customers->name : '' }}</td>
            
           <!--  @if(getCreatedByDetails($invoice->user_type, $invoice->created_by) !== null)
                <td>{{ getCreatedByDetails($invoice->user_type, $invoice->created_by)['name'] .' '.
                        getCreatedByDetails($invoice->user_type, $invoice->created_by)['last_name']
                    }}
                </td>
            @else
                <td>Not Set</td>
            @endif -->
            <td>{{ $invoice->prod ?  $invoice->prod->name : '' }}</td>
            <td>{{ $invoice->billingAmount }}</td>

            <td>{{ $invoice->status }}</td>
            <td>{{ $invoice->customers ? $invoice->customers->phone : '' }}</td>

            <td>
                <span>
                    <a href="{{ route('billing.invoice.show', [$invoice->id, $currentStatus, 'next']) }}" class="btn-icon btn-tooltip" title="View"><i class="las la-eye"></i></a>
                </span>                                                       
            </td>                                                    
        </tr>
    @endforeach
@endif
</tbody>

</table>
</div>

</div>