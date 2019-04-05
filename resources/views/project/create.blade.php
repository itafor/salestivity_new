@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Project Management')])  

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Project') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('project.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('customer_account') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="customer_account">{{ __('Customer Account') }}</label>
                                    <input type="text" name="customer_account" id="customer_account" class="form-control form-control-alternative{{ $errors->has('customer_account') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('customer_account') }}" required autofocus>

                                    @if ($errors->has('customer_account'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer_account') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Product Name') }}</label>
                                    <!-- <input type="email" name="email" id="product_id-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required> -->
                                    <div class="col-sm-6">
                                    <select name="product_id" id="product_id">
                                        <option value="">Choose a Product</option>
                                        @foreach($products as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    
                                    @if ($errors->has('product_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('technician') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Technician') }}</label>
                                    <input type="text" name="technician" id="technician" class="form-control form-control-alternative{{ $errors->has('technician') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician') }}" value="{{ old('technician') }}" required>
                                    
                                    @if ($errors->has('technician'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('technician') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('start') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="start">{{ __('Start date') }}</label>
                                    <input type="date" name="start" id="start" class="form-control form-control-alternative{{ $errors->has('start') ? ' is-invalid' : '' }}" placeholder="{{ __('Start date') }}" value="{{ old('start') }}" required autofocus>

                                    @if ($errors->has('start'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('start') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('end') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="end">{{ __('End date') }}</label>
                                    <input type="date" name="end" id="end" class="form-control form-control-alternative{{ $errors->has('end') ? ' is-invalid' : '' }}" placeholder="{{ __('End date') }}" value="{{ old('end') }}" required >

                                    @if ($errors->has('end'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('end') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="notes">{{ __('Notes') }}</label>
                                    <input type="textarea" name="notes" id="notes" class="form-control form-control-alternative{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Notes') }}" value="{{ old('notes') }}" required >

                                    @if ($errors->has('notes'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('notes') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('uploads') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="uploads">{{ __('Uploads') }}</label>
                                    <input type="file" name="uploads[]" id="uploads" class="form-control form-control-alternative{{ $errors->has('uploads') ? ' is-invalid' : '' }}" multiple required>

                                    @if ($errors->has('uploads'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('uploads') }}</strong>
                                        </span>
                                    @endif
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