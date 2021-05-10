@extends('layouts.app', ['title' => __('Invoice Management'), 'icon' => 'las la-receipt'])
@section('content')
@include('users.partials.header', ['title' => __('Edit Invoice')])  

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
                                <h3 class="mb-0">{{ __('Update Invoice') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('billing.invoice.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('billing.invoice.update') }}" autocomplete="off">
                            @csrf
                            <!-- <input type="hidden" name="status" value="Not Confirmed"> -->
                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                            <div class="pl-lg-4 pr-lg-4">
                                  <div class="row">
                                
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
                                            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select">
                                                <option value="">Choose a Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{$invoice->category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
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
                                                <option value="{{$invoice->subcategory ? $invoice->subcategory->id : ''}}">{{$invoice->subcategory ? $invoice->subcategory->name : ''}}</option>
                                              
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
                                        <option value="{{$invoice->prod ? $invoice->prod->id : ''}}">{{$invoice->prod ? $invoice->prod->name : ''}}</option>
                                           
                                    </select>
                                  <!-- </div> -->
                                </div>  
                                </div>

                                    <div class="col-6">
                                            <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  
                                    <select name="customer" id="customer" class="form-control" onchange="myFunction(event)">
                                        <option value="">Choose a Customer</option>
                                            @foreach($customers as $key => $customer)
                                                <option value="{{ $customer->id }}" {{$customer->id == $invoice->customer ? 'selected' : ''}}>{{ $customer->name }}</option>
                                            @endforeach
                                    </select>
                                 
                                </div>
                                    </div>

                                   

                                </div>

                                 <div class="row">
                                    <div class="col-6">
                                         <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cost">{{ __('Cost') }}</label>
                                    <input type="number" name="cost" id="productPrice" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" value="{{ $invoice->cost }}" required >
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
                                    <input type="number" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Discount') }}" value="{{ $invoice->discount }}">
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-4">
                                         <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="discount">{{ __('Billing Amount') }}</label>
                                    <input type="number" min="1" name="billingAmount" id="billingAmount" class="form-control form-control-alternative{{ $errors->has('billingAmount') ? ' is-invalid' : '' }}" placeholder="{{ __('Billing Amount') }}" value="{{ $invoice->billingAmount }}" required readonly="">
                                    @if ($errors->has('billingAmount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billingAmount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>

                                         <div class="col-4">
                                             
                                <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeline">{{ __('Due Date') }}</label>
                                   <input type="text" name="due_date" id="due_date" class="date form-control form-control-alternative{{ $errors->has('due_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Due Date') }}"  data-toggle="datepicker" value="{{\Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y')}}" required>

                            @if ($errors->has('due_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('due_date') }}</strong>
                                </span>
                            @endif
                                </div>
                                    </div>

                                    <div class="col-4">
                                             
                                <div class="form-group{{ $errors->has('timeline') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="timeline">{{ __('Timeline (in days)') }}</label>
                                    <input type="text" name="timeline" id="timeline" class="form-control form-control-alternative{{ $errors->has('timeline') ? ' is-invalid' : '' }}" placeholder="{{ __('Timeline') }}" value="{{ $invoice->timeline }}" required>

                                    @if ($errors->has('timeline'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('timeline') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    </div>
                                </div>
                                 
                              <div class="row">

      <div class="col">
<label class="form-control-label" for="company_email_id">{{ __('Delivery Email') }}</label>
   <select class="form-control" name="company_email_id" id="company_email_id" required>
       <option value="">Select delivery email</option>
          @foreach($companyEmails as $email)
        <option value="{{$email->id}}" {{$email->id == $invoice->company_email_id ? 'selected' : ''}}>{{$email->email}}</option>
        @endforeach
   </select>

    @if ($errors->has('company_email_id'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('company_email_id') }}</strong>
        </span>
    @endif
    </div>

      <div class="col">
<label class="form-control-label" for="company_bank_acc_id">{{ __('Company Bank Account') }}</label>
         <select class="form-control" name="company_bank_acc_id" id="company_bank_acc_id" required>
       <option value="">Select bank account</option>
          @foreach($companyBankDetails as $bankDetail)
        <option value="{{$bankDetail->id}}" {{$bankDetail->id == $invoice->company_bank_acc_id ? 'selected' : ''}}>{{$bankDetail->bank_name}} - {{$bankDetail->account_number}}</option>
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

@endsection