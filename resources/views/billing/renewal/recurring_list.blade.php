                

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
                <th ><b>{{ __('Due Date') }}</b></th>
                <th ><b>{{ __('Customer') }}</b></th>
                <th ><b>{{ __('Product') }}</b></th>
                <th ><b>{{ __('Amount') }}</b></th>
                <th ><b>{{ __('Balance') }}</b></th>
                <th ><b>{{ __('Status') }}</b></th>

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

                <td>
                    {{ date('Y/m/d', strtotime($renewal->end_date)) }}
                    </td>



                <td>{{ $renewal->customers ? $renewal->customers->name : '' }}</td>
                <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}</td>
                <td>{{ $renewal->billingAmount }}</td>
                <td>{{ $renewal->billingBalance }}</td>



                <td>{{$renewal->status}}</td>

                <td>

                    <div class="col-4 text-right">
                        <a href="{{ route('billing.renewal.show', [$renewal->id, $currentStatus, 'next']) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
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