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
             @include('alerts.messages')


        <form method="post" action="{{ route('customer.insale') }}" class='form-group' autocomplete="off">
                            @csrf

         @if($orderOwner)
<div class="form-horizontal">
  Customer: <strong>{{$orderOwner->name}}</strong>
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
             @if($orderOwner)
<div class="form-horizontal">
  <strong>{{$orderOwner->name}}</strong> orders
</div>
<br>
@enderror

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
                                        @if(isset($orders) && $orders != '')

                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->product ?  $order->product->name : 'N/A' }}</td>
                                                <td>{{ last7DaysOrder($order->customer_id, $order->product_id) }}</td>
                                                <td>{{ last30DaysOrder($order->customer_id, $order->product_id) }}</td>
                                                <td>{{ last90DaysOrder($order->customer_id, $order->product_id) }}</td>

                                            </tr>
                                            @endforeach
                                            @else
                                             <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
<!-- <hr> -->
                             <div class="table-responsive">
        @if($orderOwner)
<div class="form-horizontal">
  <strong>{{$orderOwner->name}}</strong> Inventory

</div>
<br>
@endif
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Quantity') }}</th>
                                            <th scope="col">{{ __('Determined Order') }}</th>
                                            <th scope="col">{{ __('Manage') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($customerInventories) && $customerInventories !='')

                                            @foreach($customerInventories as $inventory)
                                            <tr>
                                                <td>{{ $inventory->product ?  $inventory->product->name : 'N/A' }}</td>
                                                <td>{{ $inventory->quantity }}</td>

                                                  <td>
                                    @include('direct-sale.orders.create_order_form')
                                                  </td>
                                                   <td>

                                                    <div class="btn-group-justified text-center" role="group">

                                                       <div class="btn-group" role="group">
                                                            <a onclick="editInventory({{$inventory->id}})" href="#" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="Edit" data-bs-toggle="modal" data-bs-target="#edit_inventory_modal"><i class="las la-edit"></i></a>
                                                        </div>

                                                         <div class="btn-group" role="group">
                                                            <a href="{{ route('inventory.show', [$inventory->id]) }}" style="margin-right: 5px;" class="" title="View">
                                                               <!--  <i class="las la-eye"></i> -->{!!count($inventory->productReviews)!!} Reviews</a>
                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>
                                            @endforeach
                                            @else
                                             <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>

     @include('direct-sale.partials.edit_inventory')

        @include('layouts.footers.auth')
    </div>
  <script type="text/javascript" src="/js/inventory.js"></script>

@endsection
