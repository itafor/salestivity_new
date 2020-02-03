@extends('layouts.app', ['title' => __('Add Billing Agent')])
@section('content')
@include('users.partials.header', ['title' => __('Add Billing Agent')])  

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Billing Agent') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.agent.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="background-color: #ffffff;">

<form method="post" action="{{ route('billing.agent.store') }}" autocomplete="off">
     @csrf
     <h6 class="heading-small text-muted mb-4">{{ __('Billing Agent information') }}</h6>
  <div class="form-row">

    <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-md-6" >
      <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
            <select name="customer_id" id="customer" class=" form-control selectOption">
                <option selected>Choose a Customer</option>
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
  <label class="form-control-label" for="product">{{ __('Billing Agent Name') }}</label>
         <input type="text"  name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value=" " required>
@if ($errors->has('name'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('name') }}</strong>
    </span>
@endif
    </div>

  </div>
    <div class="form-row">
<div class="form-group{{ $errors->has('productPrice') ? ' has-danger' : '' }} col-md-6">
    <label class="form-control-label" for="productPrice">{{ __('Billing Agent Phone') }}</label>
    <input type="tel" name="phone" id="phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value=" " required>

    @if ($errors->has('phone'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('phone') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="email">{{ __('Billing Agent Email') }}</label>
    <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}">

    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
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


