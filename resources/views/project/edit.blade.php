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
                                <h3 class="mb-0">{{ __('Edit Project') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('project.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project information') }}</h6>
                            <div class="pl-lg-4 pr-lg-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <input type="hidden" name="project_id" value="{{$project->id}}">
                                    <div class="form-group{{ $errors->has('customer_account') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="customer_account">{{ __('Customer Account') }}</label>
                                        <select name="customer_account" id="customer_account" class="form-control border-input"> 
                                            <option value="">Choose a Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{$customer->id == $project->customer_account ? 'selected' : ''}}>{{ $customer->name }}</option>
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
                                                <option value="{{ $product->id }}" {{$product->id == $project->product_id ? 'selected' : ''}}>{{ $product->name }}</option>
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
                                        <input type="text" name="technician" id="technician" class="form-control form-control-alternative{{ $errors->has('technician') ? ' is-invalid' : '' }}" placeholder="{{ __('Technician') }}" value="{{ old('technician', $project->technician) }}" required>
                                        @if ($errors->has('technician'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('technician') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="start_date">{{ __('start date') }}</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control form-control-alternative border-input{{ $errors->has('start_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Start date') }}" data-toggle="datepicker" value="{{\Carbon\Carbon::parse($project->start_date)->format('d/m/Y')}}" required autofocus>

                                            @if ($errors->has('start'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('end') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="end">{{ __('End date') }}</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control form-control-alternative border-input{{ $errors->has('end') ? ' is-invalid' : '' }}" placeholder="{{ __('End date') }}" data-toggle="datepicker" value="{{\Carbon\Carbon::parse($project->end_date)->format('d/m/Y')}}" required >

                                            @if ($errors->has('end'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="notes">{{ __('Notes') }}</label>
                                            <input type="textarea" name="notes" id="notes" class="form-control form-control-alternative border-input{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Notes') }}" value="{{ old('notes', $project->notes) }}" >

                                            @if ($errors->has('notes'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('notes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                       <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('notes') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="notes">{{ __('Status') }}</label>
                                            <select  name="status" id="status" class="form-control form-control-alternative border-input{{ $errors->has('notes') ? ' is-invalid' : '' }}" placeholder="{{ __('Status') }}" value="{{ old('status') }}" >
                                                <option value="{{$project->status}}">{{$project->status}}</option>
                                                <option value="Planning">Planning</option>
                                                <option value="Work in Progress">Work in Progress</option>
                                                <option value="On Hold">On Hold</option>
                                                <option value="Completed">Completed </option>
                                                <option value="Cancelled">Cancelled </option>
                                            </select>

                                            @if ($errors->has('notes'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('notes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                   
                                <div class="form-group{{ $errors->has('uploads') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="uploads">{{ __('Uploads') }}</label>
                                        <input type="file" name="uploads" id="uploads" class="form-control form-control-alternative file-input {{ $errors->has('uploads') ? ' is-invalid' : '' }}" >

                                        @if ($errors->has('uploads'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('uploads') }}</strong>
                                            </span>
                                        @endif

                                <br>                    
                  @if($project->uploads)
                  <img src="{{$project->uploads}}" alt="Photo" width="50" height="50">
                  @else
                  <span>No photo</span>
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