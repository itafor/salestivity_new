@extends('layouts.app', ['title' => __('Sales Management'), 'icon' => 'las la-calculator'])
@section('content')
@include('users.partials.header', ['title' => __('Add Sales')])

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Manage Sale') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="sales_id" value="{{$sale->id}}">
                            <div class="pl-lg-4 pr-lg-4">

                                <div class="row">
                                
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
                                            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select" required>
                                                <option value="">Choose a Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{$category->id == $sale->category_id ? 'selected' : ''}}>{{ $category->name }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                      <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
                                            <select name="sub_category_id" id="sub_category_id" class="form-control border-input" data-toggle="select" required>
                                                <option value="">Select Sub Category</option>
                                               
                                                 @foreach(productSubCategories() as $subCategory)
                                                    <option value="{{ $subCategory->id }}" {{$subCategory->id == $sale->sub_category_id ? 'selected' :'' }}>{{ $subCategory->name }}</option>
                                                @endforeach
                                              
                                            </select>     
                                            @if ($errors->has('sub_category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                           <div class="form-group{{ $errors->has('product') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="product">{{ __('Product') }}</label>
                                  <!-- <div class="col-sm-6" data-toggle="select"> -->
                                    <select name="product" id="product_id" class="form-control " data-toggle="select">
                                        <option value="">Choose a Product</option>
                                           @foreach($products as $key => $produc)
                                             <option value="{{ $produc->id }}" {{$produc->id == $sale->product_id ? 'selected' : ''}}>{{ $produc->name }}</option>
                                            @endforeach
                                    </select>
                                  <!-- </div> -->
                                </div>  
                                </div>

                                </div>
                                <div class="row">
                                  <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                            <input type="number" name="price" id="productPrice" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" value="{{ old('price',$sale->price) }}" required>
                                            @if ($errors->has('price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="qty">{{ __('Quantity') }}</label>
                                            <input type="number" name="quantity" id="qty" class="form-control form-control-alternative{{ $errors->has('quantity') ? ' is-invalid' : '' }}" placeholder="{{ __('Quantity') }}" value="{{ old('quantity',$sale->quantity) }}" required>
                                            @if ($errors->has('quantity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                         <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('total_amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Total Amount') }}</label>
                                            <input type="text" name="total_amount" id="total-amount" class="form-control form-control-alternative{{ $errors->has('total_amount') ? ' is-invalid' : '' }}" placeholder="{{ __('Total Amount') }}" value="{{ old('total_amount',$sale->total_amount) }}" required readonly="readonly">
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
                                            <select name="sales_person_id" id="sales_person" class="form-control form-control-alternative border-input {{ $errors->has('sales_person_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Sales Person') }}" value="{{ old('sales_person_id') }}" >
                                                <option value="">Select Sales Person</option>
                                                @foreach($salesPerson as $sales)
                                                    <option value="{{ $sales->id }}" {{$sales->id == $sale->sales_person_id ? 'selected' : ''}}>{{ $sales->name }} {{ $sales->last_name }}</option>
                                                @endforeach
                                                 
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
                                            <select name="location_id" id="location" class="form-control form-control-alternative border-input {{ $errors->has('location_id') ? ' is-invalid' : '' }}" required >
                                                <option value="">Select Location</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" {{$location->id == $sale->location_id ? 'selected' : ''}}>{{ $location->location }}</option>
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

   

        // calculate value for Total Amount according to number of quantity
        $(document).on('keyup', '#qty', function(){
            var product_price = $('#productPrice').val();
            var quantity = $(this).val();

           if(quantity && $.isNumeric(quantity)){
             totalAmount = product_price * parseFloat(quantity)
           
            $('#total-amount').val(totalAmount);
                }else{
            $('#total-amount').val('');
                }

        });
    </script>
@endsection