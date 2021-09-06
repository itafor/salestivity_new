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
                             <div class="col-6">
                                           <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                  <!-- <div class="col-sm-6" data-toggle="select"> -->
                                    <select name="product" id="product_id" class="form-control " data-toggle="select">
                                        <option value="">Choose a Product</option>
                                           
                                    </select>
                                  <!-- </div> -->
                                </div>  
                                </div>

                                    <div class="col-6">
                                            <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <!-- <div class="col-sm-6" data-toggle="select"> -->
                                  <!-- pass in the customer_id to the pivot table ie customer_invoice -->
                                    <select name="customer" id="customer" class="form-control" onchange="myFunction(event)">
                                        <option value="">Choose a Customer</option>
                                            @foreach($customers as $key => $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                    </select>
                                 
                                </div>
                                    </div>

                                   

                                </div>

                                 <div class="row">
                                    <div class="col-6">
                                         <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cost">{{ __('Cost') }} <span class="currency"></span></label>
                                    <input type="number" name="cost" id="productPrice" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" value="{{ old('cost') }}" required >
                                    @if ($errors->has('cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>

                                    <div class="col-6">
                                          <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="discount">{{ __('Discount(in %)') }}</label>
                                    <input type="number" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Discount') }}" value="{{ old('discount') }}" >
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6">
                                         <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="discount">{{ __('Billing Amount') }} <span class="currency"></span></label>
                                    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value=" " required>
                                    @if ($errors->has('billingAmount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billingAmount') }}</strong>
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
                                    <div class="col-6">
                                         <div class="form-group{{ $errors->has('payment_due') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="payment_due">{{ __('Payment Due') }} <span class="currency"></span></label>
                                    <input type="number" min="1" name="payment_due" id="payment_due" class="form-control form-control-alternative{{ $errors->has('payment_due') ? ' is-invalid' : '' }}" placeholder="{{ __('Payment due') }}" value=" " required >
                                    @if ($errors->has('payment_due'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('payment_due') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>

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

                                  
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                         <div class="form-group{{ $errors->has('payment_due') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="payment_due">{{ __('Terms and Conditions') }}</label>
                                 
                                    <textarea name="term_condition" class="form-control form-control-alternative{{ $errors->has('payment_due') ? ' is-invalid' : '' }}" placeholder="Terms and conditions" rows="5" required></textarea>
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
    </div>

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
<script type="text/javascript">

    //Assign billing amount to payment due
    $("#productPrice").on("keyup", function(){
      let   productPrice = $(this).val();
    $("#billingAmount").val(productPrice);
    $("#payment_due").val(productPrice);
    $("#discount").val('');
    })

//Assign billing amount to payment due
    $("#billingAmount").on("keyup", function(){
      let   billingAmount = $(this).val();
    $("#payment_due").val(billingAmount);
    $("#discount").val('');
    })

    //auto input billing balance when amout paid is entered
$("body").on("keyup", "#payment_due", function () {
    let paymentdue = $(this).val();
    // alert(paymentdue);
    let balance = 0;
    let billingAmount = $("#billingAmount").val();
    if (parseFloat(paymentdue) > parseFloat(billingAmount)) {
        alert(
            "Ooops!! Payment due exceed Billing Amount, please check and try again"
        );
        
        $("#payment_due").val("");
        $("#payment_due").val(billingAmount);

    } else {
        // $("#payment_due").val(billingAmount);
    }
});
// disallow negative or zero input
$(document).on("keyup", "#payment_due", function (e) {
    e.preventDefault();
    let value = e.target.value;
    if (value <= 0) {
        $(this).val("");
    }
});

</script>

@endsection
