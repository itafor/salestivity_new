@extends('layouts.app', ['title' => __('Targets Management')])
@section('content')
@include('users.partials.header', ['title' => __('All Sales')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Field Sales List') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">{{ __('Add Sale') }}</a>
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
                        <table class="table align-items-center table-bordered" >
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Total Amount') }}</th>
                                    <th scope="col">{{ __('Sales Person') }}</th>
                                    <th scope="col">{{ __('Location') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($sales as $sale)
                               <tr>
                                    <td>{{ $sale->products->name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>{{ $sale->price }}</td>
                                    <td>{{ $sale->total_amount }}</td>
                                    <td>{{ $sale->salesPerson->name }}</td>
                                    <td>{{ $sale->location->location }}</td>
                               <td>   
                                    <span>
                                        <div class="col-4 text-right">
                                            <a href="{{ route('sales.show', [$sale->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                            
                                        </div>
                                    </span>
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