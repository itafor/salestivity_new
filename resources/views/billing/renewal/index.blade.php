@extends('layouts.app', ['title' => __('Billing')])

@section('content')
@include('users.partials.header', ['title' => __('All Renewals')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Renewals') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.create') }}" class="btn btn-sm btn-primary">{{ __('Create Renewal') }}</a>
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
                                            <th ><b>{{ __('Customer') }}</b></th>
                                            <th ><b>{{ __('Product') }}</b></th>
                                            <th ><b>{{ __('End Date') }}</b></th>
                                            <th class="text-center"><b>{{ __('Action') }}</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renewals as $renewal)
                                            <tr>
                                                <td>{{ $renewal->customers ? $renewal->customers->name : '' }}</td>
                                                <td>{{ $renewal->product_name? $renewal->product_name->name:'N/A' }}</td>
                                                <td>{{ date("jS F, Y", strtotime($renewal->end_date)) }}</td>
                                                
                                                <td>
                                                    <div class="col-4 text-right">
                                                        <a href="{{ route('billing.renewal.show', [$renewal->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                        @if($renewal->status == 'Paid')
                                                        <a  class="btn btn-sm btn-primary text-white" onclick="completelypayAlert()">{{ __('Payment') }}</a>
                                                        @else

                                                        <a  class="btn btn-sm btn-primary text-white" onclick="renewalPayment({{$renewal->id}})">{{ __('Payment') }}</a>

                                                        @endif
                                                        <a onclick="deleteData('billing','renewal',{{$renewal->id}})"><button class="btn btn-sm btn-danger">{{ __('Delete') }}</button></a>
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