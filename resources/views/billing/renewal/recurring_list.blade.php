                


        

    <div class="row">
       <div class="col">

      <form action="{{route('renewal.filter.startdate')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
      <div class="form-group mb-2 mr-1">
      <label for="start_date" >Filter by start date</label>
      <input type="text" class="form-control-plaintext" name="start_date" placeholder="{{ __('Filter by start date') }}"  data-toggle="datepicker" value="{{ isset($startDate) ? $startDate :'' }}" required>
       @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
      <button type="submit" class="btn mb--3">Filter</button>
      </form>
      </div> 

       <div class="col">
       <form action="{{route('renewal.filter.enddate')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
      <div class="form-group mb-2 mr-1">
      <label for="reply_to_email" >Filter by end date</label>
      <input type="text" class="form-control-plaintext" name="end_date" placeholder="{{ __('Filter by end date') }}"  data-toggle="datepicker" value="{{ isset($endDate) ? $endDate :'' }}"  required>
       @if ($errors->has('end_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
      </div>
      <button type="submit" class="btn mb--3">Filter</button>
      </form>
      </div> 
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

                <table class="table table-bordered invoices"  style="width:100%">
                <thead>
                <tr>
                <!-- <th ><b>{{ __('ID') }}</b></th> -->
                <th ><b>{{ __('Due Date') }}</b></th>
                <!-- <th ><b>{{ __('Start Date') }}</b></th> -->
                <th class="word-wrap"><b>{{ __('Customer') }}</b></th>
                <th ><b>{{ __('Product') }}</b></th>
                <th ><b>{{ __('Amount') }}</b></th>
                <th ><b>{{ __('Balance') }}</b></th>
                <th ><b>{{ __('Status') }}</b></th>
                <th ><b>{{ __('Phone Number') }}</b></th>

                <th class="text-center"><b>{{ __('Action') }}</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($renewals as  $renewal)

                    <?php   
                    $currentStatus= "";
                    if($renewal->status == 'Partly paid'){
                         $currentStatus = "partly_paid";
                    }elseif($renewal->status == 'Pending'){
                         $currentStatus = "Pending";
                    }elseif($renewal->status == 'Paid'){
                         $currentStatus = "paid";
                    }else{
                         $currentStatus = "all";
                    }

                     ?>
                <tr>

                <td>{{ date('Y/m/d', strtotime($renewal->end_date)) }}</td>
                <!-- <td>{{ date('Y/m/d', strtotime($renewal->start_date)) }}</td> -->
               



                <td class="word-wrap">{{ $renewal->customers ? $renewal->customers->name : '' }}</td>
                <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}</td>
                <td>{{ $renewal->billingAmount }}</td>
                <td>{{ $renewal->billingBalance }}</td>



                <td>{{$renewal->status}}</td>
                <td>{{ $renewal->customers ? $renewal->customers->phone : '' }}</td>
                

                <td>

                    <div class="col-4 text-right">
                        <a href="{{ route('billing.renewal.show', [$renewal->id, $currentStatus, 'next']) }}" class="btn-icon btn-tooltip" title="View"><i class="las la-eye"></i></a>
                        <!-- @if($renewal->status == 'Paid')
                        <a  class="btn btn-sm btn-primary" onclick="completelypayAlert()"title="Payment"><i class="las la-money-bill"></i></a>
                        @else

                        <a  class="btn btn-sm btn-primary" onclick="renewalPayment({{$renewal->id}})" title="Renewal"><i class="las la-comment-dollar"></i></a>
                        @endif -->
                    </div>
                </td>
                </tr>
                @endforeach
                </tbody>

         
                </table>

                </div>