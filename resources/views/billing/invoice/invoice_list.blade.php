
    <div class="row">

      <form action="{{route('search.invoice.by.start.end.date')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
       <div class="col">

      <div class="form-group mb-2 mr-1">
      <label for="start_date" >Start Date</label>
      <input type="text" class="form-control-plaintext" name="start_date" placeholder="{{ __('Enter start date') }}"  data-toggle="datepicker" value="{{ isset($startDate) ? $startDate :'' }}" required>
       @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
      </div> 
       <div class="col">
      <div class="form-group mb-2 mr-1">
      <label for="reply_to_email" >End Date</label>
      <input type="text" class="form-control-plaintext" name="end_date" placeholder="{{ __('Enter end date') }}"  data-toggle="datepicker" value="{{ isset($endDate) ? $endDate :'' }}"  required>
       @if ($errors->has('end_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
      </div>
      </div> 
      <div class="col">
      <button type="submit" class="btn mb--3">Search</button>
      </div>


      </form>

      </div> 

<br>

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