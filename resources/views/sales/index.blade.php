@extends('layouts.app', ['title' => __('Sales Management'), 'icon' => 'las la-calculator'])
@section('content')
@include('users.partials.header', ['title' => __('All Sales')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Field Sales List') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Sale') }}"><i class="las la-plus-circle"></i></a>
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
                                <table class="table align-items-center table-bordered datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                            <th scope="col">{{ __('Price') }}</th>
                                            <th scope="col">{{ __('Total Amount') }}</th>
                                            <th scope="col">{{ __('Sales Person') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Location') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($sales->isEmpty())
                                                <tr>
                                                    <td colspan="8" style="text-align: center">
                                                        <h3>No data available</h3>
                                                    </td>
                                                </tr>
                                        @else
                                            @foreach($sales as $sale)
                                                <tr>
                                                        <td>{{ $sale->products ? $sale->products->name : 'N/A' }}</td>
                                                        <td>{{ $sale->quantity }}</td>
                                                        <td>{{ $sale->price }}</td>
                                                        <td>{{ $sale->total_amount }}</td>
                                                        <td>{{ $sale->salesPerson ? $sale->salesPerson->name : 'N/A' }} {{ $sale->salesPerson ? $sale->salesPerson->last_name :
                                                        'N/A'  }}</td>
                                                        @if(getCreatedByDetails($sale->user_type, $sale->created_by) !== null)
                                                            <td>{{ getCreatedByDetails($sale->user_type, $sale->created_by)['name'] .' '.
                                                                    getCreatedByDetails($sale->user_type, $sale->created_by)['last_name']
                                                                }}
                                                            </td>
                                                        @else
                                                            <td>Not Set</td>
                                                        @endif
                                                        <td>{{ $sale->location->location }}</td>
                                                    <td>   
                                                        <span>
                                                            <div class="col-4 text-right">
                                                                <a href="{{ route('sales.show', [$sale->id]) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
                                                                
                                                            </div>
                                                        </span>
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