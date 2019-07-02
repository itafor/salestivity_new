@extends('layouts.app', ['title' => __('Manage Renewal')])
@section('content')
@include('users.partials.header', ['title' => __('Manage Renewal')])  

<script>
    $(document).ready(function(){
        /*Disable all input type="text" box*/
        $('#form1 input').prop("disabled", true);
        $('#form1 select').prop("disabled", true);
        $('#form1 button').hide();

        $('#edit').click(function(){
        $('#form1 input').prop("disabled", false);
        $('#form1 select').prop("disabled", false);
        $('#title').html('Edit Invoice');
        $('#form1 button').show();
        $('#edit').toggle();
        })
        
    });

    // Jquery for select and multiple select
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});   
    // Jquery for select and single select
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});   
	</script>

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0" id="title">{{ __('Manage Renewal') }}</h3>
                            </div>
                            <!-- <div class="col-4 text-right">
                                <button href="{{ route('billing.invoice.index') }}" id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('billing.renewal.update', [$renewal->id]) }}" id="form1" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Renewal information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="customer">{{ __('Customer Name') }}</label>
                                  <!-- <div class="col-sm-6" > -->
                                  <!-- pass in the customer_id to the pivot table ie customer_invoice -->
                                    <select name="customer_id" id="customer" class="form-control " onchange="myFunction(event)">
                                        <option value="{{ $renewal->customers->id }}">{{ $renewal->customers->name }}</option>
                                            @foreach($customers as $key => $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Pass in this name to the database and store in invoices table -->
                                    <input type="hidden" id="myText" class="form-control" name="customer" value="{{ $renewal->customer }}">
                                  <!-- </div> -->
                                  <script>
                                    function myFunction(e) {
                                    var sel = document.getElementById("customer");
                                    var text = sel.options[sel.selectedIndex].text; 
                                    document.getElementById("myText").value = text;
                                    }
                                  </script>
                                </div>

                                
                                
                                <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="start_date">{{ __('Start Date') }}</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control form-control-alternative{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start Date') }}" value="{{ $renewal->start_date }}" required>

                                    @if ($errors->has('start_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('timeline') }}</strong>
                                        </span>
                                    @endif
                                </div>                             

                                <!-- <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div> -->
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <h3 class="heading-small text-muted mb-4">Manage Renewal</h3>

                        <form action="{{ route('billing.renewal.pay') }}" method="post">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ $renewal->customers->id }}">
                            <input type="hidden" name="renewal_id" value="{{ $renewal->id }}">
                            <input type="hidden" name="status" value="Renewal">
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="cost">{{ __('Cost') }}</label>
                                    <input type="number" name="cost" id="cost" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" value="{{ $renewal->amount }}" required >
                                    @if ($errors->has('cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="category">{{ __('Category') }}</label>
                                <select name="category_id" id="category" class="form-control" data-toggle="select">
                                    <option value="">Add Category </option>
                                        @foreach($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="sub_category_id">{{ __('Add Sub Category') }}</label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control" data-toggle="select">
                                    <option value="">Add Sub Category </option>
                                        @foreach($sub_categories as $key => $sub_category)
                                            <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                        @endforeach
                                </select>
                                @if ($errors->has('sub_category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sub_category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="product">{{ __('Add Products') }}</label>
                                <!-- <div class="col-sm-6" data-toggle="select"> -->
                                <select name="product[]" id="product" class="form-control js-example-basic-multiple" data-toggle="select" multiple="multiple">
                                    <option value="">Add more products </option>
                                        @foreach($products as $key => $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                </select>
                                @if ($errors->has('product'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="discount">{{ __('Discount(in %)') }}</label>
                                <input type="number" name="discount" id="discount" class="form-control form-control-alternative{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="{{ __('Discount') }}" value="{{ old('discount') }}" required >
                                @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!-- <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control" data-toggle="select">
                                    <option value="">Select Status </option>
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Paid">Paid</option>
                                </select>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div> -->
                            <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="amount">{{ __('Amount Paid') }}</label>
                                <input type="number" name="amount" id="discount" class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ old('amount') }}" required >
                                @if ($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Add Payment') }}</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection