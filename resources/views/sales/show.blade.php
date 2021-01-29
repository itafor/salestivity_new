@extends('layouts.app', ['title' => __('Sales Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Sales')])

<script>
    $(document).ready(function(){
		/*Disable all input type="text" box*/
		$('#form1 input').prop("disabled", true);
		$('#form1 button').hide();
        $('#form1 select').prop("disabled", true);

		$('#edit').click(function(){
		$('#form1 input').prop("disabled", false);
        $('#form1 button').toggle();
        $('#form1 select').prop("disabled", false);
		$('#edit').toggle();
		})
		
	});
</script>

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Sale') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }} </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.update', $sale->id) }}" autocomplete="off" id="form1">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Sales information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-product">{{ __('Product') }}</label>
                                            <select name="product" id="input-product" class="form-control form-control-alternative{{ $errors->has('product') ? ' is-invalid' : '' }}" placeholder="{{ __('Product') }}" value="{{ old('product') }}" >
                                                <option value="{{ $sale->product_id }}">{{ $sale->products->name }}</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('product'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('product') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="qty">{{ __('Quantity') }}</label>
                                            <input type="number" name="quantity" id="qty" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="{{ $sale->quantity }}" required>
                                            @if ($errors->has('quantity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                            <input type="number" name="price" id="input-price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" value="{{ $sale->price }}" required>
                                            @if ($errors->has('price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('total_amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Total Amount') }}</label>
                                            <input type="text" name="total_amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('total_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Total Amount') }}" value="{{ $sale->total_amount }}" required>
                                            @if ($errors->has('total_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('total_amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('sales_person_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="sales_person">{{ __('Sales Person') }}</label>
                                            <select name="sales_person_id" id="sales_person" class="form-control form-control-alternative{{ $errors->has('sales_person_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Sales Person') }}" value="{{ old('sales_person_id') }}" >
                                                <option value="{{ $sale->sales_person_id }}">{{ $sale->salesPerson->name }}</option>
                                                @foreach($salesPerson as $sales)
                                                    <option value="{{ $sales->id }}">{{ $sales->name }} {{ $sales->last_name }}</option>
                                                @endforeach
                                                    <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</option>
                                            </select>
                                            @if ($errors->has('sales_person_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sales_person_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('location_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="location">{{ __('Location') }}</label>
                                            <select name="location_id" id="location" class="form-control form-control-alternative{{ $errors->has('location_id') ? ' is-invalid' : '' }}" required >
                                                <option value="{{ $sale->location_id }}">{{ $sale->location->location }}</option>
                                                @foreach($locations as $locate)
                                                    <option value="{{ $locate->id }}">{{ $locate->location }}</option>
                                                @endforeach
                                                
                                            </select>
                                            @if ($errors->has('location_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('location_id') }}</strong>
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
                    $('#input-price').val(val.standard_price);
                });
            });
        }

        $('#input-product').change(function () {
            selectProduct($(this).val());
            // $('#input-unit').prop('disabled', false)
        });

        // calculate value for Total Amount according to number of quantity
        $('.form-group').on('input', '#qty', function(){
            var totalAmount = $('#input-price').val().replace( /,/g, '');
    
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