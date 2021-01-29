@extends('layouts.app', ['title' => __('Product Management')])
@section('content')
@include('users.partials.header', ['title' => __('Product')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Product') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('product.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('product.store') }}" autocomplete="off">
                            @csrf
                            
                            <div class="pl-lg-4 pr-lg-4">
                                <div class="row">
                                
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="category_id">{{ __('Category') }}</label>   
                                            <select name="category_id" id="category_id" class="form-control border-input" data-toggle="select" required>
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
                                            <select name="sub_category_id" id="sub_category_id" class="form-control border-input" data-toggle="select" required>
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
                                  

                                        <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="name">{{ __('Product Name *') }}</label>
                                            <input type="text" name="name" id="name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Product Name') }}" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('standard_price') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="standard_price">{{ __('Standard Price') }}</label>
                                            <input type="number" name="standard_price" id="standard_price" class="form-control form-control-alternative{{ $errors->has('standard_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Standard Price') }}" value="{{ old('standard_price') }}" required autofocus>

                                            @if ($errors->has('standard_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('standard_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="description">{{ __('Description') }}</label>
                                            <textarea name="description" id="description" class="form-control form-control-alternative border-input{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" value="{{ old('description') }}" required rows="3"></textarea>

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