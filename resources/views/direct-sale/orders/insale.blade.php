@extends('layouts.app', ['title' => __('Insale Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('Insale')])

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Insale') }}  </h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('order.lists') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

        <form method="post" action="{{ route('customer.insale') }}" class='form-group' autocomplete="off">
                            @csrf

         @if($orderOwner)
<div class="form-horizontal">
  Customer: {{$orderOwner->name}}
</div>
<br>
                        @endif
  <div class="form-horizontal">
         <select name="customer_id" id="customer" class="form-control selectOption" style="width:280px;max-width:280px;display:inline-block">
        <option selected>Customer name</option>
        @foreach(allCustomers() as $key => $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>

    @error('customer_id')
<small class="text-danger">{{$message}}</small>
@enderror

    <button type="submit" 
        class="btn-icon" title="Search customer order" 
        style="margin-left:-2px;margin-top:-2px;min-height:44px;">
            <i class="las la-search"></i>
     </button>
  </div>
</form>
   <div class="table-responsive">
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Last 7 days') }}</th>
                                            <th scope="col">{{ __('Last 30 days') }}</th>
                                            <th scope="col">{{ __('Last 90 days') }}</th>
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
                                                <td>{{ $order->product ?  $order->product->name : 'N/A' }}</td>
                                                <td>{{ last7DaysOrder($order->customer_id, $order->product_id) }}</td>
                                                <td>{{ last30DaysOrder($order->customer_id, $order->product_id) }}</td>
                                                <td>{{ last90DaysOrder($order->customer_id, $order->product_id) }}</td>
                                               
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
<hr>
                             <div class="table-responsive">
        @if($orderOwner)
<div class="form-horizontal">
  {{$orderOwner->name}} Inventory
</div>
<br>
@endif
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customerInventories->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($customerInventories as $inventory)
                                            <tr>
                                                <td>{{ $inventory->product ?  $inventory->product->name : 'N/A' }}</td>
                                                <td>{{ $inventory->quantity }}</td>
                                               
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

        @include('layouts.footers.auth')
    </div>

@endsection
