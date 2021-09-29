@extends('layouts.app', ['title' => __('Target Management'), 'icon' => 'las la-bullseye'])
@section('content')
@include('users.partials.header', ['title' => __('Add Target')])

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Target') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('target.sales.persons') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('target.update', [$target->id]) }}" autocomplete="off">
                            <input type="hidden" value="Open" name="status">
                            <!-- <input type="hidden" value="0" name="percentage"> -->

                            <!-- this hidden value is prefilled using jquery -->
                            <input type="hidden" value="{{ $target->department_id }}" name="department_id" id="dept_id">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Target information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('sales') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-sales">{{ __('Sales Person') }}</label>
                                            <select name="sales" id="unit-sales" class="form-control form-control-alternative{{ $errors->has('sales') ? ' is-invalid' : '' }}" readonly>
                                                <option value="{{ $target->sales_person_id }}">{{ $target->getName($target->sales_person_id) }}</option>
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
                                            <select name="manager" id="input-manager" class="form-control form-control-alternative{{ $errors->has('manager') ? ' is-invalid' : '' }}" placeholder="{{ __('Line Manager') }}" value="{{ $target->getName($target->sales_person_id) }}" readonly >
                                                <option value="{{ $target->manager }}">{{ $target->getName($target->manager) }}</option>
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
                                            <select name="type" id="input-type" class="form-control form-control-alternative{{ $errors->has('type') ? ' is-invalid' : '' }}" placeholder="{{ __('Target Type') }}" value="{{ old('type') }}" readonly>
                                                <option value="{{ $target->type }}">{{ $target->getType($target->type) }}</option>
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
                                            <select name="product_id" id="input-product" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="{{ old('product_id') }}" readonly>
                                                <option value="{{ $target->product_id }}">{{ $target->products->name }}</option>
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
                                            <input type="text" name="unit_price" id="unit-input" class="form-control form-control-alternative{{ $errors->has('unit_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Unit Price') }}" value="{{ $target->unit_price }}" readonly>

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
                                            <input type="num" name="qty" id="qty" class="form-control form-control-alternative{{ $errors->has('qty') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="{{ $target->qty }}" readonly>

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
                                            <input type="number" name="product_amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('product_amount') ? ' is-invalid' : '' }}" placeholder="{{ __(' Amount') }}" value="{{ $target->amount }}" readonly>
                                            @if ($errors->has('product_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('product_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('product_amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amt-achieved">{{ __('Amount Achieved') }}</label>
                                            <input type="number" name="amt_achieved" id="input-achieve_amount" class="form-control form-control-alternative{{ $errors->has('amt_achieved') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount Achieved') }}" value="{{ $target->amt_achieved }}" readonly>
                                            @if ($errors->has('amt_achieved'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amt_achieved') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('percent_achieved') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-percent_achieved">{{ __('Percentage Achieved') }}</label>
                                            <input type="number" name="percent_achieved" id="input-percentage" class="form-control form-control-alternative{{ $errors->has('product_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Percentage Acheived') }}" value="{{ $target->percentage }}" readonly>
                                            @if ($errors->has('percent_achieved'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('percent_achieved') }}</strong>
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
            // $('#input-unit').prop('readonly', false)
        });

        // Auto fill department id when a sales person has been picked
        function selectSales(value) {
            $.get('/getsales/' + value, function (data) {
                // console.log(data.depts);
                jQuery.each(data.depts, function (i, val) {  
                    // console.log(val.id)
                    $('#dept_id').val(val.id);
                });
            });
        }

        $('#input-sales').change(function () {
            selectSales($(this).val());
            // $('#input-unit').prop('readonly', false)
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