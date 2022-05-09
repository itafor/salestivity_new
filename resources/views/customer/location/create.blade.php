@extends('layouts.app', ['title' => __('Location Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('Location')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Location') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('product.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.location.store') }}" autocomplete="off">
                            @csrf
                            
                            <div class="pl-lg-4 pr-lg-4">

                                  <fieldset>
                                
                               <h2>Address:</h2>
                                <div class="row">

                                     <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('customer_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="customer_id">{{ __('Customer') }}</label>
                                <select name="customer_id" id="customer" class=" form-control selectOption" required>
                                <option selected>Choose a Customer</option>
                                @foreach(allCustomers() as $key => $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                                </select>
                                @error('customer_id')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="country_id">{{ __('Country') }}</label>
                                           
                                            <select name="country" id="country_id" class="form-control form-control-alternative border-input colored-option {{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country') }}" required data-live-search="true">
                                                <option value="">Select a country</option>
                                                @foreach($countries as $country)
                                                <option {{ $country->sortname == $location ? "selected" : "" }} value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('State') }}</label>
                                            <select name="state" id="state_id" class="form-control form-control-alternative border-input{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state') }}" required >
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                      
                                </div>

                                <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="city_id">{{ __('City') }}</label>
                                            <select name="city" id="city_id" class="form-control form-control-alternative border-input{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('street') }}" required >
                                                <option value="">Select City</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-street">{{ __('Street Address') }}</label>
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ old('street') }}" required >

                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                      <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('landmark') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-landmark">{{ __('Landmark') }}</label>
                                            <input type="text" name="landmark" id="input-landmark" class="form-control form-control-alternative{{ $errors->has('landmark') ? ' is-invalid' : '' }}" placeholder="{{ __('landmark') }}" value="{{ old('landmark') }}" required >

                                            @if ($errors->has('landmark'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('landmark') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                            </fieldset>
                               
                                
                                

                                

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