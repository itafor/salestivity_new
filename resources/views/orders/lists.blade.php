@extends('layouts.app', ['title' => __('Order Management'), 'icon' => 'las la-suitcase'])
@section('content')
@include('users.partials.header', ['title' => __('All Orders')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Orders') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('order.create') }}" class="btn-icon btn-tooltip" title="{{ __('Create order') }}"><i class="las la-cart-plus"></i></a>
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
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Customer') }}</th>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                            <th scope="col">{{ __('Salesman') }}</th>
                                            <!-- <th scope="col">{{ __('Author') }}</th> -->
                                            <th scope="col" class="text-center">{{ __('Manage') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->customer ? $order->customer->name .' '. $order->customer->last_name : 'N/A' }}</td>
                                                <td>{{ $order->product ?  $order->product->name : 'N/A' }}</td>
                                                <td>{{ $order->quantity ?  $order->quantity : 'N/A' }}</td>
                                                <td>{{ $order->user ?  $order->user->name . ' ' . $order->user->last_name : 'N/A' }}</td>
                                               
                                                {{--@if(getCreatedByDetails($order->user_type, $order->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($order->user_type, $order->created_by)['name'] .' '.
                                                            getCreatedByDetails($order->user_type, $order->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif --}}
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('order.edit', [$order->id]) }}" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="Edit"><i class="las la-edit"></i></a>
                                                        </div> 
                                                        <div class="btn-group" role="group">
                                                             <a onclick="return confirm('Do you really want to delete this order?');" href="{{route('order.destroy', [$order->id]) }}" class="btn-icon btn-tooltip" title="Delete"><i class="las la-trash-alt"></i></a>
                                                        </div>                                                        
                                                    </div>                                                    
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