@extends('layouts.app', ['title' => __('Recurring Management'), 'icon' => 'las la-file-invoice-dollar'])

@section('content')
@include('users.partials.header', ['title' => __('Recurring')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Recurring Invoices') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.create') }}" class="btn-icon btn-tooltip" title="{{ __('Create Recurring') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        

                            <div class="table-responsive">
                                <table class="table  table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th ><b>{{ __('Invoice Number') }}</b></th>
                                            <th ><b>{{ __('Customer') }}</b></th>
                                            <th ><b>{{ __('Product') }}</b></th>
                                            <th ><b>{{ __('End Date') }}</b></th>
                                            <th class="text-center"><b>{{ __('Action') }}</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renewals as $renewal)
                                            <tr>
                                                <td>{{ $renewal->invoice_number ? $renewal->invoice_number : 'N/A' }}</td>
                                                <td>{{ $renewal->customers ? $renewal->customers->name : '' }}</td>
                                               <td>{{ $renewal->prod? $renewal->prod->name:'N/A' }}
                                                <td>
                                                    {{ strftime('%Y-%b-%d', strtotime($renewal->end_date)) }}
                                                    </td>
                                                
                                                <td>

                                                    

                                                    <div class="col-4 text-right">
                                                        <a href="{{ route('billing.renewal.show', [$renewal->id]) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
                                                        @if($renewal->status == 'Paid')
                                                        <a  class="btn btn-sm btn-primary" onclick="completelypayAlert()"title="Payment"><i class="las la-money-bill"></i></a>
                                                        @else

                                                        <a  class="btn btn-sm btn-primary" onclick="renewalPayment({{$renewal->id}})" title="Renewal"><i class="las la-comment-dollar"></i></a>

                                                        @endif


                                                     <!--  <a onclick="return confirm_delete()"  href="{{route('items.destroy',['renewal',$renewal->id])}}"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a> -->
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
    @include('billing.renewal.payment.create')
  </div>
@endsection