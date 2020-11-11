@extends('layouts.app', ['title' => __('Add Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Add Recurring')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
<div class="col-md-12">
<div class="card">
  <div class="card-header bg-white border-0">
    <div class="row align-items-center">
        <div class="col-8">
            <h3 class="mb-0">{{ __('Add New Recurring') }} </h3>
        </div>
        <div class="col-4 text-right">
            <a href="{{ route('billing.renewal.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
        </div>
    </div>
</div>
  <div class="card-body">
 <form method="post" action="{{ route('billing.renewal.store') }}" autocomplete="off" class="mt--3">
     @csrf
  <div class="row">
    <div class="col">
<label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
    <select name="customer_id" id="customer" class=" form-control selectOption">
        <option selected>Choose a Customer</option>
        @foreach($customers as $key => $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
   @error('customer_id')
<small class="text-danger">{{$message}}</small>
@enderror
    </div>
    <div class="col">
<label class="form-control-label" for="product">{{ __('Product') }}</label>
    <select name="product" id="product_id" class=" form-control form-control-alternative border-input {{ $errors->has('product') ? ' is-invalid' : '' }}" >
        <option selected>Choose a Product</option>
            @foreach($products as $key => $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select>
@error('product')
    <small class="text-danger">{{$message}}</small>
    @enderror
    </div>
  </div>

  <div class="row">
    <div class="col">
<label class="form-control-label" for="productPrice">{{ __('Product Price') }}</label>
    <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value=" " required readonly="">

    @if ($errors->has('productPrice'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('productPrice') }}</strong>
        </span>
    @endif
    </div>
    <div class="col">
<label class="form-control-label" for="discount">{{ __('Discount') }}</label>
    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount') }}">

    @if ($errors->has('discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('discount') }}</strong>
        </span>
    @endif
    </div>
    <div class="col">
<label class="form-control-label" for="productPrice">{{ __('Billing Amount') }}</label>
        <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value=" " required readonly="">

        @if ($errors->has('billingAmount'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('billingAmount') }}</strong>
            </span>
        @endif
    </div>
  </div>


    <div class="row mt-2">
    <div class="col">
        <label class="form-control-label" for="discount">{{ __('Contact Emails') }} <button type="button" class="btn btn-sm btn-default" onclick="selectAllcontactEmails()">Select all</button>  <button type="button" class="btn btn-sm btn-default" onclick="deSelectAllcontactEmails()">Deselect all</button></label>
        <select name="contact_emails[]" class="form-control contact_emails " multiple="true" id="contact_emails">
        </select>
        @error('contact_emails')
        <small class="text-danger">{{$message}}</small>
        @enderror
        </div>
  </div>

      <div class="row">

            <div class="col">
<label class="form-control-label" for="discount">{{ __('CC') }}</label>
        <input name="company_email" class="form-control company_email border-input" id="company_email">
        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="col">
<label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
        <input type="text" name="start_date" id="startdate" class="date form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}"  data-toggle="datepicker" value="{{ old('start_date') }}" required>

        @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
    </div>
    <div class="col">
<label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="date form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}"  data-toggle="datepicker" value="{{ old('end_date') }}" required>

    @if ($errors->has('end_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('end_date') }}</strong>
        </span>
    @endif
    </div>
  </div>

<div class="row">
    <div class="col">
<label class="form-control-label" for="discount">{{ __('Description') }}</label>
    <textarea name="description" class="form-control border-input" id="renewal_description"></textarea>

    @if ($errors->has('description'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('description') }}</strong>
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




           <!--  <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Recurring') }} </h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.renewal.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="background-color: #ffffff;">

                        <form method="post" action="{{ route('billing.renewal.store') }}" autocomplete="off">
                             @csrf
                             <h6 class="heading-small text-muted mb-4">{{ __('Recurring information') }}</h6>
                             <div class="pl-lg-4 pr-lg-4">
                              <div class="row">
                                <fieldset>
                                <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-md-6" >
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                        <select name="customer_id" id="customer" class=" form-control selectOption">
                                            <option selected>Choose a Customer</option>
                                            @foreach($customers as $key => $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                       @error('customer_id')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>

                            <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }} col-md-6">
                              <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                    <select name="product" id="product_id" class=" form-control form-control-alternative border-input {{ $errors->has('product') ? ' is-invalid' : '' }}" >
                                        <option selected>Choose a Product</option>
                                            @foreach($products as $key => $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                             @error('product')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                            </div>
                            </fieldset>

                            <fieldset>

  
                                <div class="form-group{{ $errors->has('productPrice') ? ' has-danger' : '' }} col-md-4">
                                    <label class="form-control-label" for="productPrice">{{ __('Product Price') }}</label>
                                    <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value=" " required readonly="">

                                    @if ($errors->has('productPrice'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('productPrice') }}</strong>
                                        </span>
                                    @endif
                                </div> 
    
                                <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }} col-md-4" >
                                    <label class="form-control-label" for="discount">{{ __('Discount') }}</label>
                                    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount') }}">

                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
   
                                <div class="form-group{{ $errors->has('billingAmount') ? ' has-danger' : '' }} col-md-4">
                                    <label class="form-control-label" for="productPrice">{{ __('Billing Amount') }}</label>
                                    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value=" " required readonly="">

                                    @if ($errors->has('billingAmount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billingAmount') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                            </fieldset>

                            <fieldset>
                                <div class="form-group{{ $errors->has('contact_emails') ? ' has-danger' : '' }} col-md-6" >
                                    <label class="form-control-label" for="discount">{{ __('Contact Emails') }} <button type="button" class="btn btn-sm btn-default" onclick="selectAllcontactEmails()">Select all</button>  <button type="button" class="btn btn-sm btn-default" onclick="deSelectAllcontactEmails()">Deselect all</button></label>
                                    <select name="contact_emails[]" class="form-control contact_emails " multiple="true" id="contact_emails">
                                        <option value="" selected="true">Choose contact emails</option>
                                    </select>

                                    @error('contact_emails')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
    
                                <div class="form-group{{ $errors->has('contact_emails') ? ' has-danger' : '' }} col-md-6" >
                                    <label class="form-control-label" for="discount">{{ __('CC') }}</label>
                                    <input name="company_email" class="form-control company_email border-input" id="company_email">

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </fieldset>

                            <fieldset>
                        <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }} col-md-6">
                                    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
                                    <input type="text" name="start_date" id="startdate" class="date form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}"  data-toggle="datepicker" value="{{ old('start_date') }}" required>

                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start_date') }}</strong>
                                        </span>
                                    @endif
                                </div> 
    
                                <div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }} col-md-6" >
                                    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
                                    <input type="text" name="end_date" id="end_date" class="date form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}"  data-toggle="datepicker" value="{{ old('end_date') }}" required>

                                    @if ($errors->has('end_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-md-12" >
                                    <label class="form-control-label" for="discount">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control border-input" id="renewal_description"></textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                  
                      
                            </fieldset>
    
                        </div>
 
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div> -->
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection


