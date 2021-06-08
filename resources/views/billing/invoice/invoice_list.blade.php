@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ session('status') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="table-responsive">

<table class="table  table-bordered datatable" style="width:100%">
<thead>
<tr>
    <th scope="col">{{ __('End Date') }}</th>
    <th scope="col">{{ __('Customer') }}</th>
    <th scope="col">{{ __('Product') }}</th>
    <th scope="col">{{ __('Cost') }}</th>
    <th scope="col">{{ __('Author') }}</th>
    <th scope="col">{{ __('Status') }}</th>
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
        <tr>
         <td>
            {{ $invoice->due_date ? date('Y/m/d', strtotime($invoice->due_date)) : 'N/A' }}
            </td>
            <td>{{ $invoice->customers->name }}</td>
            <td>{{ $invoice->prod ?  $invoice->prod->name : 'N/A' }}</td>
            <td>{{ $invoice->cost }}</td>
            @if(getCreatedByDetails($invoice->user_type, $invoice->created_by) !== null)
                <td>{{ getCreatedByDetails($invoice->user_type, $invoice->created_by)['name'] .' '.
                        getCreatedByDetails($invoice->user_type, $invoice->created_by)['last_name']
                    }}
                </td>
            @else
                <td>Not Set</td>
            @endif
            <td>{{ $invoice->status }}</td>
            <td>
                <span>
                    <a href="{{ route('billing.invoice.show', [$invoice->id]) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
                </span>                                                       
            </td>                                                    
        </tr>
    @endforeach
@endif
</tbody>
</table>
</div>

</div>