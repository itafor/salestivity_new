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
                            <div class="pl-lg-4">
                              <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <div class="col-sm-6" data-toggle="select">
                                  <!-- pass in the customer_id to the pivot table ie customer_renewal -->
                                    <select name="customer_id" id="customer" class="form-control select2-multi" onchange="myFunction(event)">
                                        <option value="">Choose a Customer</option>
                                        @foreach($customers as $key => $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Pass in this name to the database and store in renewals table -->
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
                                <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="amount">{{ __('Amount') }}</label>
                                    <input type="number" name="amount" id="amount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ old('amount') }}" required >

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('period') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="period">{{ __('Timeline (in days)') }}</label>
                                    <input type="text" name="period" id="period" class="form-control form-control-alternative{{ $errors->has('period') ? ' is-invalid' : '' }}" placeholder="{{ __('Period') }}" value="{{ old('periodPeriod') }}" required>

                                    @if ($errors->has('period'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                    @endif
                                </div>                                

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