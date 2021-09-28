@extends('layouts.app', ['title' => __('Project Management'), 'icon' => 'las la-gem' ])
@section('content')
@include('users.partials.header', ['title' => __('Project Management')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Project') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('project.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project information') }}</h6>
                            <div class="pl-lg-4 pr-lg-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('customer_account') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="customer_account">{{ __('Customer Account') }}</label>
                                        <select name="customer_account" id="customer_account" class="form-control border-input"> 
                                            <option value="">Choose a Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('customer_account'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer_account') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Product Name') }}</label>
                                        
                                        <select name="product_id" id="product_id" class="form-control border-input"> 
                                            <option value="">Choose a Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                                    <div class="form-group{{ $errors->has('technician') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">{{ __('Technician') }}</label>
                                       <select name="technician_id" id="sales_person" class="form-control form-control-alternative border-input {{ $errors->has('technician_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Sales Person') }}" value="{{ old('technician_id') }}" >
                                                <option value="">Select Technician</option>
                                                @foreach($salesPerson as $sales)
                                                    <option value="{{ $sales->id }}">{{ $sales->name }} {{ $sales->last_name }}</option>
                                                @endforeach
                                                 
                                            </select>
                                        @if ($errors->has('technician_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('technician_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('start') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="start">{{ __('Start date') }}</label>
                                            <input type="text" name="start_date" id="start" class="form-control form-control-alternative border-input{{ $errors->has('start') ? ' is-invalid' : '' }}" placeholder="{{ __('Start date') }}" data-toggle="datepicker" value="{{ old('start') }}" required autofocus>

                                            @if ($errors->has('start'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('end') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="end">{{ __('End date') }}</label>
                                            <input type="text" name="end_date" id="end" class="form-control form-control-alternative border-input{{ $errors->has('end') ? ' is-invalid' : '' }}" placeholder="{{ __('End date') }}" data-toggle="datepicker" value="{{ old('end') }}" required >

                                            @if ($errors->has('end'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                               

                                       <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="notes">{{ __('Status') }}</label>
                                            <select  name="status" id="status" class="form-control form-control-alternative border-input{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Status') }}" value="{{ old('status') }}" >
                                                <option>Select Status</option>
                                                <option value="Planning">Planning</option>
                                                <option value="Work in Progress">Work in Progress</option>
                                                <option value="On Hold">On Hold</option>
                                                <option value="Completed">Completed </option>
                                                <option value="Completed">Cancelled </option>
                                            </select>

                                            @if ($errors->has('notes'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('notes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                        <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="notes">{{ __('Notes') }}</label>
                                            <textarea cols="10"  name="notes" id="notes" class="form-control form-control-alternative border-input{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Notes') }}" value="{{ old('notes') }}" ></textarea>

                                            @if ($errors->has('notes'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('notes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    



                                <div class="form-group{{ $errors->has('uploads') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="uploads">{{ __('Uploads') }}</label>
                                        <input type="file" name="uploads" id="uploads" class="form-control form-control-alternative file-input {{ $errors->has('uploads') ? ' is-invalid' : '' }}">

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