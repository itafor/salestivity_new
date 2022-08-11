@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])

@section('content')
@include('users.partials.header', ['title' => __('All Invoices')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Invoices') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Invoice') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                          <div class="col-xl-6">
                                <div class="form-group dropdown">
                                    <button type="button" class="btn btn-icon btn-sm dropdown-toggle invoiceTab" data-toggle="dropdown">
                                        Outstanding 
                                    </button>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item" href="{{ route('billing.invoice.view', ['all']) }}">All</a>
                                        <a class="dropdown-item" href="{{ route('billing.invoice.view', ['paid']) }}">Paid</a>
                                         <a class="dropdown-item" href="{{ route('billing.invoice.view', ['pending']) }}">Pending</a>
                                        <a class="dropdown-item" href="{{ route('billing.invoice.view', ['partly_paid']) }}">Partly Paid</a>

                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6"></div>

                        <div class="col-12">
                           <?php   
                 
                             $status = "outstanding";

                           ?> 
                            @include('billing.invoice.filterInvoice')
                            @include('billing.invoice.invoice_list')
                          
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection