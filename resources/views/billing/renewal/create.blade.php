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
                        <!-- <form method="post" action="{{ route('billing.renewal.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Renewal information') }}</h6>
                            <div class="pl-lg-4">
                              <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <div class="col-sm-6" data-toggle="select">
                                  
                                    <select name="customer_id" id="customer" class="form-control select2-multi" onchange="myFunction(event)">
                                        <option value="">Choose a Customer</option>
                                        @foreach($customers as $key => $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <input type="hidden" id="myText" class="form-control" name="customer">
                                  </div>
                                  <script>
                                    function myFunction(e) {
                                    var sel = document.getElementById("customer");
                                    var text = sel.options[sel.selectedIndex].text; 
                                    document.getElementById("myText").value = text;
                                    }
                                  </script>
                                </div>
                                <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                  <div class="col-sm-6" data-toggle="select">
                                    <select name="product" id="product" class="form-control" data-toggle="select">
                                        <option value="">Choose a Product</option>
                                            @foreach($products as $key => $product)
                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                               
                                <div class="row">
                                <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}" value="{{ old('start_date') }}" required>

                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}" value="{{ old('end_date') }}" required>

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
                            </div>
                        </form> -->





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
    </div>

<div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }} col-md-6">
  <label class="form-control-label" for="product">{{ __('Product') }}</label>
        <select name="product" id="product" class="form-control" data-toggle="select">
            <option value="">Choose a Product</option>
                @foreach($products as $key => $product)
                <option value="{{ $product->name }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

  </div>
  
  <div class="form-row">
<div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }} col-md-6">
    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
    <input type="text" name="start_date" id="start_date" class="form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }} datepicker" placeholder="{{ __('Start Date') }}" value="{{ old('start_date') }}" required>

    @if ($errors->has('start_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('start_date') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }} datepicker" placeholder="{{ __('End Date') }}" value="{{ old('end_date') }}" required>

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
