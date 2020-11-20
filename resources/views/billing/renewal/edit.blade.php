@extends('layouts.app', ['title' => __('Edit Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Recurring')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
<div class="card">
  <div class="card-header">
    <div class="float-left">Edit Recurring</div>
    <div class="float-right">
        <a href="{{route('billing.renewal.index')}}">Back to List</a>
    </div>
  </div>
  <div class="card-body">
    <form method="post" action="{{ route('billing.renewal.update') }}" autocomplete="off">
     @csrf
  <div class="form-row">
    <input type="hidden" name="renewal_id" value="{{$renewal->id}}">
    <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-md-6" >
      <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
            <select name="customer_id" id="customer" class="form-control">
                <option value="">Choose a Customer</option>
                @foreach($customers as $key => $customer)
                    <option value="{{ $customer->id }}" {{$customer->id == $renewal->customer_id ? 'selected' : ''}}>
                        {{ $customer->name }}
                    </option>
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
                <option value="{{ $product->id }}" {{$product->id == $renewal->product ? 'selected' : ''}}>{{ $product->name }}</option>
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
<div class="form-group{{ $errors->has('productPrice') ? ' has-danger' : '' }} col-md-4">
    <label class="form-control-label" for="productPrice">{{ __('Product Price') }}</label>
    <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value="{{old('productPrice', $renewal->productPrice)}}" required readonly="">

    @if ($errors->has('productPrice'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('productPrice') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }} col-md-4" >
    <label class="form-control-label" for="discount">{{ __('Discount') }}</label>
    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount',$renewal->discount) }}">

    @if ($errors->has('discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('discount') }}</strong>
        </span>
    @endif
</div>
    
  



   
<div class="form-group{{ $errors->has('billingAmount') ? ' has-danger' : '' }} col-md-4">
    <label class="form-control-label" for="productPrice">{{ __('Billing Amount') }}</label>
    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value="{{old('billingAmount', $renewal->billingAmount)}}" required readonly="">

    @if ($errors->has('billingAmount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('billingAmount') }}</strong>
        </span>
    @endif
</div> 
    </div>

       <div class="row mt-2">
    <div class="col">
        <label class="form-control-label" for="discount">{{ __('Contact Emails') }} 
            <!-- <button type="button" class="btn btn-sm btn-default" onclick="selectAllcontactEmails()">Select all</button> 
             <button type="button" class="btn btn-sm btn-default" onclick="deSelectAllcontactEmails()">Deselect all</button> -->
         </label>
        <select name="contact_emails[]" class="form-control contact_emails " multiple="true" id="contact_emails">
            @if($renewal->contacts)
                @foreach($renewal->contacts as $contactEmail)
                    <option value="{{$contactEmail->contact->id}}" selected="selected">{{$contactEmail->contact->email}}</option>
                @endforeach
            @endif

           <!--   @if(customerContacts($renewal->customer_id))
                @foreach(customerContacts($renewal->customer_id) as $contact)
                    <option value="{{$contact->id}}">{{$contact->email}}</option>
                @endforeach
            @endif -->
        </select>
        @error('contact_emails')
        <small class="text-danger">{{$message}}</small>
        @enderror
        </div>
  </div>

              <div class="col">
<label class="form-control-label" for="discount">{{ __('CC') }}</label>
        <input name="company_email" class="form-control company_email border-input" value="{{$renewal->customers->email}}" id="company_email" readonly>
        @if ($errors->has('company_email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('company_email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-row">
<div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-md-12" >
    <label class="form-control-label" for="discount">{{ __('Description') }}</label>
    <textarea name="description" class="form-control" id="description">{{old('description', $renewal->description)}}</textarea>

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
    <input type="text" name="start_date" id="start_date" class="date form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}"  data-toggle="datepicker" value="{{\Carbon\Carbon::parse($renewal->start_date)->format('d/m/Y')}}" required>

    @if ($errors->has('start_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('start_date') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }} col-md-6" >
    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="date form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}"  data-toggle="datepicker" value="{{\Carbon\Carbon::parse($renewal->end_date)->format('d/m/Y')}}" required>

    @if ($errors->has('end_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('end_date') }}</strong>
        </span>
    @endif
</div>
    
  </div>
 
    <div class="text-center">
    <button type="submit" class="btn btn-success mt-4" disabled="disabled">{{ __('Save') }}</button>
    </div>
</form>
  </div>
</div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection


