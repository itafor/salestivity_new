@extends('layouts.app', ['title' => __('Recurring Management'), 'icon' => 'las la-file-invoice-dollar'])
@section('content')
@include('users.partials.header', ['title' => __('Recurring')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
<div class="card">
         <?php   
            $currentStatus= "";
            if(isset($renewal)){
            if($renewal->status == 'Partly paid'){
            $currentStatus = "partly_paid";
            }elseif($renewal->status == 'Pending'){
            $currentStatus = "Pending";
            }elseif($renewal->status == 'Paid'){
            $currentStatus = "paid";
            }else{
            $currentStatus = "all";
            }
            }
            ?>
  <div class="card-header">
    <div class="float-left">Edit Recurring</div>
    <div class="float-right">
       <a href="{{ route('billing.renewal.invoice.view', [$currentStatus]) }}" class="btn-icon btn-tooltip btn-sm" title="{{ __('Back to List') }}"><i class="fa fa-arrow-left"></i></a>
    </div>
  </div>
  <div class="card-body">
    <form method="post" action="{{ route('billing.renewal.update') }}" autocomplete="off">
     @csrf

     <div class="row">

    <div class="col-xl-6">
        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select">
                <option value="">Choose a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{$category->id == $renewal->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
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
                <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
              
            </select>     
            @if ($errors->has('sub_category_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

</div>
  <div class="form-row">
    <input type="hidden" name="renewal_id" value="{{$renewal->id}}">

    <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }} col-md-6">
  <label class="form-control-label" for="product">{{ __('Product') }}</label>
        <select name="product" id="product_id" class="form-control form-control-alternative{{ $errors->has('product') ? ' is-invalid' : '' }}">
            <option value="">Choose a Product</option>
                @foreach($products as $key => $produc)
                <option value="{{ $produc->id }}" {{$produc->id == $renewal->prod->id ? 'selected' : ''}}>{{ $produc->name }}</option>
            @endforeach
        </select>
@if ($errors->has('product'))
    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first('product') }}</strong>
    </span>
@endif

    </div>

    <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }} col-md-6" >
      <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
            <select name="customer_id" id="customer" class="form-control selectOption">
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


  </div>
    <div class="form-row">
<div class="form-group{{ $errors->has('productPrice') ? ' has-danger' : '' }} col-md-3">
    <label class="form-control-label" for="productPrice">{{ __('Product Price:') }}

</label>

                 <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value="{{old('productPrice', $renewal->productPrice)}}" required  {{$renewal->status == 'Pending' ? "" :"readonly"}} >
   

    @if ($errors->has('productPrice'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('productPrice') }}</strong>
        </span>
    @endif
</div> 
    
    <div class="form-group{{ $errors->has('billingAmount') ? ' has-danger' : '' }} col-md-3">
      <label class="form-control-label" for="currency_id">{{ __('Currency') }}</label>
     <select name="currency_id" id="currency_id" class="form-control border-input" data-toggle="select" required   {{$renewal->status == 'Pending' ? "" :"disabled"}}>
        <option value="">Choose a Currency</option>
            @foreach($currencies as $currency)
                <option value="{{ $currency->id }}" {{$renewal->currency && $renewal->currency->id == $currency->id ? 'selected':''}}>{!! $currency->symbol !!}</option>
            @endforeach
    </select>
                                           
   @error('currency_id')
<small class="text-danger">{{$message}}</small>
@enderror
</div> 

<div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }} col-md-3" >
    <label class="form-control-label" for="discount">{{ __('Discount') }}</label>
    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount',$renewal->discount) }}" {{$renewal->status == 'Pending' ? "" :"readonly"}}>

    @if ($errors->has('discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('discount') }}</strong>
        </span>
    @endif
</div>
    



  



   
<div class="form-group{{ $errors->has('billingAmount') ? ' has-danger' : '' }} col-md-3">
    <label class="form-control-label" for="productPrice">{{ __('Billing Amount') }} </label>
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
      <label class="form-control-label" for="discount">{{ __('Contact Emails') }} <button type="button" class="btn btn-sm btn-default" onclick="selectAllcontactEmails()">Select all</button>  <button type="button" class="btn btn-sm btn-default" onclick="deSelectAllcontactEmails()">Deselect all</button></label>
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



  <div class="form-row">

                    <div class="col">
<label class="form-control-label" for="duration_type">{{ __('Duration Type') }}</label>
        <select name="duration_type" class="form-control" id="duration_type" required>
            <option  value="">Choose</option>
            <option  value="{{$renewal->duration_type}}" selected="selected">{{$renewal->duration_type}}</option>
            <option  value="Annually">Annually</option>
            <!-- <option  value="Monthly">Monthly</option> -->
        </select>

        @if ($errors->has('duration_type'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('duration_type') }}</strong>
            </span>
        @endif
    </div>
<div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }} col-md-4">
    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
    <input type="text" name="start_date" id="start_date" class="date form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}"  data-toggle="datepicker" value="{{\Carbon\Carbon::parse($renewal->start_date)->format('d/m/Y')}}" required>

    @if ($errors->has('start_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('start_date') }}</strong>
        </span>
    @endif
</div> 
    
<div class="form-group{{ $errors->has('end_date') ? ' has-danger' : '' }} col-md-4" >
    <label class="form-control-label" for="end_date">{{ __('End Date') }}</label>
    <input type="text" name="end_date" id="end_date" class="date form-control form-control-alternative{{ $errors->has('end_date') ? ' is-invalid' : '' }}" placeholder="{{ __('End Date') }}"  data-toggle="datepicker" value="{{\Carbon\Carbon::parse($renewal->end_date)->format('d/m/Y')}}" required>

    @if ($errors->has('end_date'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('end_date') }}</strong>
        </span>
    @endif
</div>
    
  </div>

  <h3 id="AnnualReminderDurationHeading">Reminder durations </h3>

     <div class="row"  id="AnnualReminderDuration">
    <div class="col">
<label class="form-control-label" for="first_duration">{{ __('First Reminder Duration') }}</label>
        <input type="number" min="1" name="first_duration" id="first_duration" class="form-control form-control-alternative{{ $errors->has('first_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 50 days to due date') }}"  value="{{$renewal->duration ? $renewal->duration->first_duration : '' }}" >

        @if ($errors->has('first_duration'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('first_duration') }}</strong>
            </span>
        @endif
    </div>
    <div class="col">
<label class="form-control-label" for="second_duration">{{ __('Second Reminder Duration') }}</label>
    <input type="number" min="1" name="second_duration" id="second_duration" class="form-control form-control-alternative{{ $errors->has('second_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 25 days to due date') }}"  value="{{$renewal->duration ? $renewal->duration->second_duration : '' }}" >

    @if ($errors->has('second_duration'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('second_duration') }}</strong>
        </span>
    @endif
    </div>
       <div class="col">
<label class="form-control-label" for="third_duration">Third Reminder Duration</label>
    <input type="number" min="0" name="third_duration" id="third_duration" class="form-control form-control-alternative{{ $errors->has('third_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 0 days to due date') }}"  value="{{$renewal->duration ? $renewal->duration->third_duration : '' }}" >

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
    <textarea name="description" class="form-control" id="description">{{old('description', $renewal->description)}}</textarea>

    @if ($errors->has('description'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
    </div>

<!--       <div class="col">
<label class="form-control-label" for="discount">{{ __('Delivery Email') }}</label>
   <select class="form-control" name="company_email_id" id="company_email_id" required>
       <option value="">Select delivery email</option>
          @foreach($companyEmails as $email)
        <option value="{{$email->id}}" {{$email->id == $renewal->company_email_id ? 'selected' : ''}}>{{$email->email}}</option>
        @endforeach
   </select>

    @if ($errors->has('company_email_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('company_email_id') }}</strong>
        </span>
    @endif
    </div> -->

      <div class="col">
<label class="form-control-label" for="discount">{{ __('Company Bank Account') }}</label>
         <select class="form-control" name="company_bank_acc_id" id="company_bank_acc_id" required>
       <option value="">Select bank account</option>
          @foreach($companyBankDetails as $bankDetail)
        <option value="{{$bankDetail->id}}" {{$bankDetail->id == $renewal->company_bank_acc_id ? 'selected' : ''}}>{{$bankDetail->bank_name}} - {{$bankDetail->account_number}}</option>
  @endforeach
   </select>
    @if ($errors->has('company_bank_acc_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('company_bank_acc_id') }}</strong>
        </span>
    @endif
    </div>
  </div>



    <div class="row">
      <div class="col">
<label class="form-control-label" for="discount">{{ __('ReplyTo Email') }}</label>
   <select class="form-control" name="reply_to_email_id" id="reply_to_email_id" required>
       <option value="">Select delivery email</option>
          @foreach($reply_to_emails as $email)
        <option value="{{$email->id}}" {{$email->id == $renewal->reply_to_email_id ? 'selected' : ''}}>{{$email->reply_to_email}}</option>
        @endforeach
   </select>

    @if ($errors->has('reply_to_email_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('reply_to_email_id') }}</strong>
        </span>
    @endif
    </div>

          <div class="col">
<label class="form-control-label" for="discount">{{ __('CC Email') }}</label>
   <select class="form-control" name="cc_email_id" id="cc_email_id" required>
       <option value="">Select CC email</option>
          @foreach($cc_emails as $email)
        <option value="{{$email->id}}" {{$email->id == $renewal->cc_email_id ? 'selected' : ''}}>{{$email->cc_email}}</option>
        @endforeach
   </select>

    @if ($errors->has('cc_email_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cc_email_id') }}</strong>
        </span>
    @endif
    </div>

      <div class="col">
<label class="form-control-label" for="discount">{{ __('Mail from Name') }}</label>
         <input class="form-control" name="mail_from_name" id="mail_from_name" value="{{$renewal->mail_from_name ? $renewal->mail_from_name : $mail_from_name->company_name}}" required>
    @if ($errors->has('mail_from_name_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('mail_from_name_id') }}</strong>
        </span>
    @endif
    </div>
  </div>
 
    <div class="text-center">
    <button type="submit" class="btn btn-success mt-4" >{{ __('Save') }}</button>
    </div>
</form>
        @include('product.editwithModal')

  </div>
</div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection


