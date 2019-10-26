@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('View Product')]) 
		
<script>
    $(document).ready(function(){
        /*Disable all input type="text" box*/
        $('#form1 input').prop("disabled", true);
        $('#form1 select').prop("disabled", true);
        $('#form1 button').hide();

        $('#edit').click(function(){
        $('#form1 input').prop("disabled", false);
        $('#form1 select').prop("disabled", false);
        $('#form1 button').show();
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
                                <h3 class="mb-0">{{ __('View Product') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.update', [$product->id]) }}" id="form1" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Product information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="name">{{ __('Product Name') }}</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Name') }}" value="{{ $product->name }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>
                                            <select name="category_id" id="category_id" class="form-control" data-toggle="select">
                                                <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
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
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="product">{{ __('Sub Category') }}</label>
                                            <select name="sub_category_id" id="sub_category_id" class="form-control" data-toggle="select">
                                                <option value="{{ $product->sub_category->id }}">{{ $product->sub_category->name }}</option>
                                                @foreach($subCategories as $subCategory)
                                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                                @endforeach
                                            </select>     
                                            @if ($errors->has('sub_category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('sub_category_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="standard_price">{{ __('Standard Price') }}</label>
                                            <input type="number" name="standard_price" id="standard_price" class="form-control form-control-alternative{{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ $product->standard_price }}" required autofocus>

                                            @if ($errors->has('standard_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('standard_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="description">{{ __('Description') }}</label>
                                            <input type="textarea" name="description" id="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" value="{{ $product->description }}" required >

                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
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

@endsection