@extends('layouts.app', ['title' => __('Project Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Invoices')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Invoices') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.create') }}" class="btn btn-sm btn-primary">{{ __('Create Invoice') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Customer') }}</th>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Cost') }}</th>
                                    <th scope="col">{{ __('Timeline') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                    
                                        <td>{{ $invoice->customer }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>{{ $invoice->cost }}</td>
                                        <td>{{ $invoice->timeline }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td>
                                            <div class="col-4 text-right">
                                                <a href="{{ route('project.create') }}" class="btn btn-sm btn-success">{{ __('Manage') }}</a>
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
            


    @include('layouts.footers.auth')
  </div>
@endsection