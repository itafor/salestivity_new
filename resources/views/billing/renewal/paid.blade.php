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
                                <h3 class="mb-0">{{ __('Paid Recurring Invoices') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.create') }}" class="btn-icon btn-tooltip" title="{{ __('Create Recurring') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                          <div class="col-xl-6">
                                <div class="form-group dropdown">
                                    <button type="button" class="btn btn-icon btn-sm  dropdown-toggle invoiceTab" data-toggle="dropdown">
                                        Paid 
                                    </button>
                                    <div class="dropdown-menu">

                                        <a class="dropdown-item" href="{{ route('billing.renewal.invoice.view', ['all']) }}">All</a>
                                       
                                        <a class="dropdown-item" href="{{ route('billing.renewal.invoice.view', ['partly_paid']) }}">Partly Paid</a>
                                       
                                        <a class="dropdown-item" href="{{ route('billing.renewal.invoice.view', ['Pending']) }}">Pending</a>

                                         <a class="dropdown-item" href="{{ route('billing.renewal.invoice.view', ['due']) }}">Due</a>

                                         <a class="dropdown-item" href="{{ route('billing.renewal.invoice.view', ['outstanding']) }}">Outstanding</a>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6"></div>

                        <div class="col-12">

                            <?php   
                 
                         $status = "paid";

                     ?> 
    @include('billing.renewal.filterRenewal')


                            
                            @include('billing.renewal.recurring_list')
                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
    @include('billing.renewal.payment.create')
  </div>
@endsection