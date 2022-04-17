@extends('layouts.app', ['title' => __('Order Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('Order')])

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Order') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('order.lists') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('order.store') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4 pr-lg-4">
            <div class="row">

                   <div class="col-xl-4">
        <div class="form-group{{ $errors->has('customer_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="customer_id">{{ __('Customer') }}</label>
           <select name="customer_id" id="customer" class=" form-control selectOption" required>
        <option selected>Choose a Customer</option>
        @foreach(allCustomers() as $key => $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
   @error('customer_id')
<small class="text-danger">{{$message}}</small>
@enderror
        </div>
    </div>

    <div class="col-xl-4">
        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>
            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select">
                <option value="">Choose a Category</option>
                    @foreach(productCategories() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
            </select>
            @error('category_id')
<small class="text-danger">{{$message}}</small>
@enderror
        </div>
    </div>

      <div class="col-xl-4">
        <div class="form-group{{ $errors->has('subcategory_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
            <select name="subcategory_id" id="sub_category_id" class="form-control border-input" data-toggle="select">
                <option value="">Select Product Sub Category</option>

            </select>
            @error('subcategory_id')
<small class="text-danger">{{$message}}</small>
@enderror
        </div>
    </div>

</div>

     <div class="row">

       <div class="col-xl-4">
        <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">

<label class="form-control-label" for="product_id">{{ __('Product') }}</label>
    <select name="product_id" id="product_id" class=" form-control form-control-alternative border-input {{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
        <option selected>Choose a Product</option>
            @foreach($products as $key => $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select>
     @error('product_id')
    <small class="text-danger">{{$message}}</small>
    @enderror
    </div>
    </div>

      <div class="col-xl-4">
        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="product">{{ __('Quantity') }}</label>
    <input type="number" min="1" name="quantity" id="quantity" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Quantity') }}">

             @error('quantity')
    <small class="text-danger">{{$message}}</small>
    @enderror
        </div>
    </div>

    <div class="col-xl-4">
        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">

<label class="form-control-label" for="status">{{ __('Status') }}</label>
    <select name="status" id="status_id" class=" form-control form-control-alternative border-input {{ $errors->has('status') ? ' is-invalid' : '' }}" >
        <option value="" selected>Choose a status</option>
            <option value="Ordered">Ordered</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
    </select>
     @error('status')
    <small class="text-danger">{{$message}}</small>
    @enderror
    </div>
    </div>

</div>
                <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

@endsection
