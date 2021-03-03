@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])

@section('content')
@include('users.partials.header', ['title' => __('All Invoices')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
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
                                <table class="table table-bordered align-items-center table-flush">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Customer') }}</th>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Cost') }}</th>
                                            <th scope="col">{{ __('Timeline') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col" colspan="2">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($invoices->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($invoices as $invoice)
                                                <tr>
                                                
                                                    <td>{{ $invoice->customers->name }}</td>
                                                    <td>{{ $invoice->prod ?  $invoice->prod->name : 'N/A' }}</td>
                                                    <td>{{ $invoice->cost }}</td>
                                                    <td>{{ $invoice->timeline }}</td>
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
                                                    <a href="{{ route('billing.invoice.show', [$invoice->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                    <!-- <a href="{{ route('billing.invoice.manage', [$invoice->id]) }}" class="btn btn-sm btn-primary">{{ __('Manage') }}</a> -->
                                                   
                                                    </span>
                                                        <div class="col-4 text-right">
                                                            
                                                        </div>
                                                    </td>
                                                    <td>
                                                   
                                                </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection