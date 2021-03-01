@extends('layouts.app', ['title' => __('Target Management'), 'icon' => 'las la-bullseye'])
@section('content')
@include('users.partials.header', ['title' => __('Add Target')])

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Target') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                 <a href="{{ route('target.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('target.store') }}" autocomplete="off">
                            <input type="hidden" value="Open" name="status">
                           <!--  <input type="hidden" value="0" name="percentage">
                            <input type="hidden" value="" name="department_id" id="dept_id"> -->
                            @csrf
                            <!-- <h6 class="heading-small text-muted mb-4">{{ __('Target information') }}</h6> -->
                            <div class="pl-lg-4 pr-lg-4">

                                        <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('department_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-dept">{{ __('Department') }}</label>
                                            <select name="department_id" id="input-dept" class="form-control" data-toggle="select">
                                                <option value="">Select a Department</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select> 

                                            @if ($errors->has('dept'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dept') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('unit_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                            <select name="unit_id" id="input-unit" class="form-control" data-toggle="select">
                                                <option value="">Select a Unit</option>
                                            </select> 

                                            @if ($errors->has('unit_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unit_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('sales') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-sales">{{ __('Sales Person') }}</label>
                                            <select name="sales" id="input-sales" class="form-control form-control-alternative border-input {{ $errors->has('sales') ? ' is-invalid' : '' }}" placeholder="{{ __('Sales Person') }}" value="{{ old('sales') }}" >
                                                <option value="">Select Sales Person</option>
                                                @foreach($salesPersons as $sales)
                                                    <option value="{{$sales->id}}">{{ $sales->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('sales'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sales') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('manager') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-manager">{{ __('Line Manager') }}</label>
                                            <select name="manager" id="input-manager" class="form-control form-control-alternative border-input {{ $errors->has('manager') ? ' is-invalid' : '' }}" placeholder="{{ __('Line Manager') }}" value="{{ old('manager') }}" >
                                                <option value="">Select Manager</option>
                                                @foreach($salesPersons as $sales)
                                                    <option value="{{$sales->id}}">{{ $sales->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('manager'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('manager') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-type">{{ __('Target Type') }}</label>
                                            <select name="type" id="input-type" class="form-control form-control-alternative border-input {{ $errors->has('type') ? ' is-invalid' : '' }}" placeholder="{{ __('Target Type') }}" value="{{ old('type') }}" >
                                                <option value="">Target Type</option>
                                                <option value="1">Weekly</option>
                                                <option value="2">Monthly</option>
                                                <option value="3">Yearly</option>
                                        
                                            </select>

                                            @if ($errors->has('type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-product">{{ __('Product Name') }}</label>
                                            <select name="product_id" id="input-product" class="form-control form-control-alternative border-input {{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="{{ old('product_id') }}" >
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('product_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('product_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('unit_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="unit-input">{{ __('Unit Price') }}</label>
                                            <input type="number" name="unit_price" id="unit-input" class="form-control form-control-alternative{{ $errors->has('unit_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Unit Price') }}" value="{{ old('unit_price') }}" required>

                                            @if ($errors->has('unit_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unit_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('qty') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="qty">{{ __('Quantity') }}</label>
                                            <input type="number" name="qty" id="qty" class="form-control form-control-alternative border-input {{ $errors->has('qty') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="{{ old('qty')}}" required>

                                            @if ($errors->has('qty'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('qty') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('product_amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Amount') }}</label>
                                            <input type="number" name="product_amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('product_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Total Amount') }}" value="{{ old('product_amount') }}" required readonly="readonly">
                                            @if ($errors->has('product_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('product_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                     <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('achieve_amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-achieve_amount">{{ __('Achieve Amount') }}</label>
                                            <input type="number" name="achieve_amount" id="input-achieve_amount" class="form-control form-control-alternative{{ $errors->has('achieve_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('achieve_amount') }}" value="{{ old('achieve_amount') }}" required>
                                            @if ($errors->has('achieve_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('achieve_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                     <div class="col-xl-12">
                                        <div class="form-group{{ $errors->has('percentage') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-percentage">{{ __('Percentage') }}</label>
                                            <input type="number" name="percentage" id="input-percentage" class="form-control form-control-alternative{{ $errors->has('percentage') ? ' is-invalid' : '' }}" placeholder="{{ __('Percentage') }}" value="{{ old('percentage') }}" required readonly="readonly">
                                            @if ($errors->has('percentage'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('percentage') }}</strong>
                                                </span>
                                            @endif
                                        </div>
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
    
    <script>

        // Auto fill unit price when a product has been picked
        function selectProduct(value) {
            $.get('/getproductprice/' + value, function (data) {
                // console.log(data.products);
                // $('#input-unit').html("");
                // $('#input-unit').append("");
                jQuery.each(data.products, function (i, val) {
                    $('#unit-input').val(val.standard_price);
                });
            });
        }

        $('#input-product').change(function () {
            selectProduct($(this).val());
            // $('#input-unit').prop('disabled', false)
        });

        // Auto fill department id when a sales person has been picked
        function selectSales(value) {
            $.get('/getsales/' + value, function (data) {
                console.log(data.depts);
                jQuery.each(data.depts, function (i, val) {  
                    // console.log(val.id)
                    $('#dept_id').val(val.id);
                });
            });
        }

        $('#input-sales').change(function () {
            selectSales($(this).val());
            // $('#input-unit').prop('disabled', false)
        });

        // calculate value for Total Amount according to number of quantity
        $('.form-group').on('input', '#qty', function(){
            var totalAmount = $('#unit-input').val().replace( /,/g, '');
    
            // console.log(totalAmount);
            $('.form-group #qty').each(function(){
                var inputVal = $(this).val();
                if($.isNumeric(inputVal)){
                    totalAmount *= parseFloat(inputVal)
                }
            });
            $('#input-amount').val(totalAmount);
        });
    </script>
@endsection