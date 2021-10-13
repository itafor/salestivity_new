@extends('layouts.app', ['title' => __('Recurring Management'), 'icon' => 'las la-file-invoice-dollar'])
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
            <a href="{{ route('billing.renewal.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
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
                <option value="">Select Product Sub Category</option>
              
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
        @foreach($customers as $key => $customer)
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
    <input type="number" min="1" name="productPrice" id="productPrice" class="form-control form-control-alternative{{ $errors->has('productPrice') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Price') }}" value=" " required>

    @if ($errors->has('productPrice'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('productPrice') }}</strong>
        </span>
    @endif
    </div>
         <div class="col">
   <label class="form-control-label" for="currency_id">{{ __('Currency') }}</label>
     <select name="currency_id" id="currency_id" class="form-control border-input" data-toggle="select" required>
        <option value="">Choose a Currency</option>
            @foreach($currencies as $currency)
                <option value="{{ $currency->id }}" {{$currency->symbol == '&#8358;' ? 'selected' : ''}}>{!! $currency->symbol !!}</option>
            @endforeach
    </select>
                                           
   @error('currency_id')
<small class="text-danger">{{$message}}</small>
@enderror
    </div>
    <div class="col">
<label class="form-control-label" for="discount">{{ __('Discount (%)') }}</label>
    <input type="number" min="1" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Discount') }}" value="{{ old('discount') }}">

    @if ($errors->has('discount'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('discount') }}</strong>
        </span>
    @endif
    </div>
    <div class="col">
<label class="form-control-label" for="productPrice">{{ __('Billing Amount') }} </label>
        <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value="" required readonly>

        @if ($errors->has('billingAmount'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('billingAmount') }}</strong>
            </span>
        @endif
    </div>
  </div>

  <div class="row">

    <div class="col-xl-6">
        <div class="form-group{{ $errors->has('value_added_tax') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="value_added_tax">{{ __('Value Added Tax (%)') }}</label>   
            <input type="number" name="value_added_tax" id="value_added_tax" class="form-control" placeholder="Enter VAT in percentage">
            @if ($errors->has('value_added_tax'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('value_added_tax') }}</strong>
                </span>
            @endif
        </div>
    </div>

      <div class="col-xl-6">
        <div class="form-group{{ $errors->has('withholding_tax') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="product">{{ __('Withholding Tax (%)') }}</label>
           <input type="number" name="withholding_tax" id="withholding_tax" class="form-control" placeholder="Enter WHT in percentage">   
            @if ($errors->has('withholding_tax'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('withholding_tax') }}</strong>
                </span>
            @endif
        </div>
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

           {{-- <div class="col">
<label class="form-control-label" for="discount">{{ __('CC') }}</label>
        <input name="company_email" class="form-control company_email border-input" value="{{authUser()->email}}" id="company_email***" readonly>
        @if ($errors->has('company_email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('company_email') }}</strong>
            </span>
        @endif
    </div> --}}



  </div>

   

        <div class="row">

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

<h3 style="display: none;" id="AnnualReminderDurationHeading">Annual Reminder durations </h3>

     <div class="row" style="display: none;" id="AnnualReminderDuration">
    <div class="col">
<label class="form-control-label" for="first_duration">{{ __('First Reminder Duration') }}</label>
        <input type="number" min="1" name="first_duration" id="first_durationX" class="form-control form-control-alternative{{ $errors->has('first_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 50 days to due date') }}"  value="60" >

        @if ($errors->has('first_duration'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('first_duration') }}</strong>
            </span>
        @endif
    </div>
    <div class="col">
<label class="form-control-label" for="second_duration">{{ __('Second Reminder Duration') }}</label>
    <input type="number" min="1" name="second_duration" id="second_durationX" class="form-control form-control-alternative{{ $errors->has('second_duration') ? ' is-invalid' : '' }}" placeholder="{{ __('E.g. 25 days to due date') }}"  value="30" >

    @if ($errors->has('second_duration'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('second_duration') }}</strong>
        </span>
    @endif
    </div>
       <div class="col">
<label class="form-control-label" for="third_duration">Third Reminder Duration</label>
    <input type="number" min="0" name="third_duration" id="third_durationX" class="form-control form-control-alternative{{ $errors->has('third_duration') ? ' is-invalid' : '' }}"  value="7" >

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

<!--       <div class="col">
<label class="form-control-label" for="discount">{{ __('Delivery Email') }}</label>
   <select class="form-control" name="company_email_id" id="company_email_id" required>
       <option value="">Select delivery email</option>
          @foreach($companyEmails as $email)
        <option value="{{$email->id}}">{{$email->email}}</option>
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
        <option value="{{$bankDetail->id}}">{{$bankDetail->bank_name}} - {{$bankDetail->account_number}}</option>
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
       <option value="">Select replyTo email</option>
          @foreach($reply_to_emails as $email)
        <option value="{{$email->id}}">{{$email->reply_to_email}}</option>
        @endforeach
   </select>

    @if ($errors->has('reply_to_email_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('reply_to_email_id') }}</strong>
        </span>
    @endif
    </div>

             <div class="col">
<label class="form-control-label" for="discount">{{ __('CC:') }}</label>
   <select class="form-control" name="cc_email_id" id="cc_email_id" required>
       <option value="">Select cc email</option>
          @foreach($cc_emails as $email)
        <option value="{{$email->id}}">{{$email->cc_email}}</option>
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
       <input class="form-control" name="mail_from_name" id="mail_from_name" value="{{$mail_from_name->company_name}}" required>
  
    @if ($errors->has('mail_from_name_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('mail_from_name_id') }}</strong>
        </span>
    @endif
    </div>
  </div>

<div class="text-center">
    <button onclick="removeDisabledAttr()" type="submit" class="btn btn-success mt-4" id="submitRenewalButtonxxx">{{ __('Save') }}</button>
</div>

</form>
  </div>
</div>

</div>



        </div>
        
        @include('layouts.footers.auth')
    </div>
<script type="text/javascript">

     $("#productPrice").on("keyup", function(){
      let   productPrice = $(this).val();
    $("#billingAmount").val(productPrice);
    $("#discount").val('');
    $("#withholding_tax").val('');
    $("#value_added_tax").val('');
    })

     $("#value_added_tax").on("keyup", function(){
      var  vat = $(this).val();
       calculateVat(vat);
      
    })

   $("#withholding_tax").on("keyup", function(){
      let  wht = $(this).val();
     
      calculateWht(wht);
      
    })

 

</script>
@endsection


