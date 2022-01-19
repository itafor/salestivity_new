@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('Add Invoice')])  

<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Invoice') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('billing.invoice.store') }}" autocomplete="off">
                            @csrf
                            <!-- <input type="hidden" name="status" value="Not Confirmed"> -->
                            <div class="pl-lg-4 pr-lg-4">
                                 <div id="product_container_id">
                                  <div class="row">
                                
                                    <div class="col-xl-3">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
                            <select name="products[112211][category_id]" id="category_id112211" class="form-control border-input category_id112211" data-toggle="select" onchange="getProductSubcategories('112211')" required>
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

                                      <div class="col-xl-3">
                                        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
                                            <select name="products[112211][sub_category_id]" id="sub_category_id112211" class="form-control border-input sub_category_id112211" onchange="getProducts('112211')" data-toggle="select" required>
                                                <option value="">Choose a Sub Category</option>
                                              
                                            </select>     
                                            @if ($errors->has('sub_category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                     <div class="col-xl-3">
                                           <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                
                                    <select name="products[112211][product_id]" id="product_id112211" class="form-control product_id112211" data-toggle="select" onchange="getProductCost('112211')" required>
                                        <option value="">Choose a Product</option>
                                           
                                    </select>
                                  
                                </div>  
                                </div>

                                   <div class="col-xl-3">
                                      <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                   <label class="form-control-label" for="product">{{ __('Product Cost') }}</label>
                                      <input type="number" name="products[112211][product_cost]"  class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }} product_cost" id="product_cost112211" placeholder="{{ __('Product Cost') }}" value="{{ old('cost') }}" readonly required >
                                </div>  
                                </div>

                                </div>


                               <!-- <div style="clear:both"></div> -->
                               
                                </div>   

                                   <div class="row">
                              
                                <div class="form-group pl-lg-4 pr-lg-4" style="margin-top: 5px;">
                                    <button type="button" id="addMoreProduct" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More Product</button>
                                </div> 
                                    
                                </div>


                                

                                 <div class="row">
                                     <div class="col-xl-4">
                                      <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                 
                                    <select name="customer" id="customer" class="form-control" onchange="myFunction(event)">
                                        <option value="">Choose a Customer</option>
                                            @foreach($customers as $key => $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                    </select>
                                 
                                </div>
                                </div>

                                    <div class="col-xl-4">
                                         <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cost">{{ __('Total Cost') }}</label>
                                    <input type="number" name="cost" id="productPrice" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Total Cost') }}" value="{{ old('cost') }}" required >
                                    @if ($errors->has('cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>



                                      <div class="col-xl-2">
                                          <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="discount">{{ __('Discount (%)') }}</label>
                                    <input type="number" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Discount') }}" value="{{ old('discount') }}" >
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>

                                   <div class="col-2">
                                 <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
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


                                <div class="row">
                                    <div class="col-6">
                                         <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="discount">{{ __('Billing Amount') }}</label>
                                    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value=" " required>
                                    @if ($errors->has('billingAmount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billingAmount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>

                
                                       <div class="col-6">
                                         <div class="form-group{{ $errors->has('payment_due') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="payment_due">{{ __('Payment Due') }}</label>
                                    <input type="number" min="1" name="payment_due" id="payment_due" class="form-control form-control-alternative{{ $errors->has('payment_due') ? ' is-invalid' : '' }}" placeholder="{{ __('Payment due') }}" value=" " required >
                                    @if ($errors->has('payment_due'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_due') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>
                               
                                </div>

                                 <div class="row">

                                       <div class="col-6">
                                             
                                <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeline">{{ __('Due Date') }}</label>
                                   <input type="text" name="due_date" id="due_date" class="date form-control form-control-alternative{{ $errors->has('due_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Due Date') }}"  data-toggle="datepicker" value="{{ old('due_date') }}" required>

                            @if ($errors->has('due_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('due_date') }}</strong>
                                </span>
                            @endif
                                </div>
                                    </div>
                                 
                         <div class="col-6">
                                             
                                <div class="form-group{{ $errors->has('timeline') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeline">{{ __('Timeline (in days)') }}</label>
                                    <input type="text" name="timeline" id="timeline" class="form-control form-control-alternative{{ $errors->has('timeline') ? ' is-invalid' : '' }}" placeholder="{{ __('Timeline') }}" value="{{ old('timeline') }}" required>

                                    @if ($errors->has('timeline'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('timeline') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>


                                 

                                  
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                         <div class="form-group{{ $errors->has('payment_due') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="payment_due">{{ __('Terms and Conditions') }}</label>
                                 
                                    <textarea name="term_condition" class="form-control form-control-alternative{{ $errors->has('payment_due') ? ' is-invalid' : '' }}" id="term_condition" placeholder="Terms and conditions" rows="5" required></textarea>
                                    @if ($errors->has('payment_due'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_due') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>
                                </div>

        <div class="row">

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
  
  
    @if ($errors->has('mail_from_name'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('mail_from_name') }}</strong>
        </span>
    @endif
    </div>
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

 <script src="{{url('js/add_more_products.js')}}"></script>
@endsection
