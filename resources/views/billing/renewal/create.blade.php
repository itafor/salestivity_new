@extends('layouts.app', ['title' => __('Add Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Recurring')])  

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

    <div class="col-xl-6">
        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select">
                <option value="">Choose a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
            </select>
            @if ($errors->has('category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

      <div class="col-xl-6">
        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
            <select name="sub_category_id" id="sub_category_id" class="form-control border-input" data-toggle="select">
                <option value="">Choose a Sub Category</option>
              
            </select>     
            @if ($errors->has('sub_category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

</div>
  <div class="row">
   
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

     <div class="col">
<label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
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
        <input name="company_email" class="form-control company_email border-input" value="{{authUser()->email}}" id="company_email***" readonly>
        @if ($errors->has('company_email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('company_email') }}</strong>
            </span>
        @endif
    </div>

    <div class="col">
<label class="form-control-label" for="duration_type">{{ __('Duration Type') }}</label>
        <select name="duration_type" class="form-control" id="duration_type" required>
            <option  value="">Choose</option>
            <option  value="Annually">Annually</option>
            <!-- <option  value="Monthly">Monthly</option> -->
        </select>

        @if ($errors->has('duration_type'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('duration_type') }}</strong>
            </span>
        @endif
    </div>

  </div>

   

        <div class="row">

    <div class="col">
<label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
        <input type="text" name="start_date" id="startdate" class="date form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}"  data-toggle="datepicker" value="{{ old('start_date') }}" required disabled>

        @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
    </div>
    <div class="col">
<label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="date form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}"  data-toggle="datepicker" value="{{ old('end_date') }}" required disabled>

    @if ($errors->has('end_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('end_date') }}</strong>
        </span>
    @endif
    </div>
  </div>

         <div class="row" style="display: none;" id="AnnualReminderDuration">

    <div class="col">
<label class="form-control-label" for="first_duration">{{ __('First Reminder Duration') }}</label>
        <input type="number" min="1" name="first_duration" id="first_duration" class="form-control form-control-alternative{{ $errors->has('first_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 50 days to due date') }}"  value="{{ old('first_duration') }}" >

        @if ($errors->has('first_duration'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('first_duration') }}</strong>
            </span>
        @endif
    </div>
    <div class="col">
<label class="form-control-label" for="second_duration">{{ __('Second Reminder Duration') }}</label>
    <input type="number" min="1" name="second_duration" id="second_duration" class="form-control form-control-alternative{{ $errors->has('second_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 25 days to due date') }}"  value="{{ old('second_duration') }}" >

    @if ($errors->has('second_duration'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('second_duration') }}</strong>
        </span>
    @endif
    </div>
       <div class="col">
<label class="form-control-label" for="third_duration">Third Reminder Duration (Expired)</label>
    <input type="number" min="0" name="third_duration" id="third_duration" class="form-control form-control-alternative{{ $errors->has('third_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 0 days to due date') }}"  value="" >

    @if ($errors->has('third_duration'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('third_duration') }}</strong>
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
    <button onclick="removeDisabledAttr()" type="submit" class="btn btn-success mt-4" id="submitRenewalButton">{{ __('Save') }}</button>
   <img src="{{URL::asset('/img/ajax-loader.gif')}}" alt="spinner" style="display: none;" id="loader">
</div>

</form>
  </div>
</div>

</div>



        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection


