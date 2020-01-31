@extends('layouts.app', ['title' => __('Add Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Add Renewal')])  

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Renewal') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

<form method="post" action="{{ route('billing.renewal.store') }}" autocomplete="off">
     @csrf
     <h6 class="heading-small text-muted mb-4">{{ __('Renewal information') }}</h6>
  <div class="form-row">

    <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-md-6" >
      <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
            <select name="customer_id" id="customer" class="form-control">
                <option value="">Choose a Customer</option>
                @foreach($customers as $key => $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('customer_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('customer_id') }}</strong>
        </span>
    @endif
    </div>

<div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }} col-md-6">
  <label class="form-control-label" for="product">{{ __('Product') }}</label>
        <select name="product" id="product_id" class="form-control form-control-alternative{{ $errors->has('product') ? ' is-invalid' : '' }}">
            <option value="">Choose a Product</option>
                @foreach($products as $key => $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
@if ($errors->has('product'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('product') }}</strong>
    </span>
@endif
    </div>

  </div>
    <div class="form-row">
<div class="form-group{{ $errors->has('productPrice') ? ' has-danger' : '' }} col-md-6">
    <label class="form-control-label" for="productPrice">{{ __('Product Price') }}</label>
    <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value=" " required readonly="">

    @if ($errors->has('productPrice'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('productPrice') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="discount">{{ __('Discount') }}</label>
    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount') }}">

    @if ($errors->has('discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('discount') }}</strong>
        </span>
    @endif
</div>
    
  </div>


    <div class="form-row">
<div class="form-group{{ $errors->has('billingAmount') ? ' has-danger' : '' }} col-md-6">
    <label class="form-control-label" for="productPrice">{{ __('Billing Amount') }}</label>
    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value=" " required readonly="">

    @if ($errors->has('billingAmount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('billingAmount') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="discount">{{ __('Description') }}</label>
    <textarea name="description" class="form-control" id="description"></textarea>

    @if ($errors->has('description'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>
    
  </div>



  <div class="form-row">
<div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }} col-md-6">
    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
    <input type="text" name="start_date" id="start_date" class="datepicker form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}" data-date-format="dd/mm/yyyy" value="{{ old('start_date') }}" required>

    @if ($errors->has('start_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('start_date') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="datepicker form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}" data-date-format="dd/mm/yyyy" value="{{ old('end_date') }}" required>

    @if ($errors->has('end_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('end_date') }}</strong>
        </span>
    @endif
</div>
    
  </div>
 
    <div class="text-center">
    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection


