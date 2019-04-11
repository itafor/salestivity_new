@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Account')]) 
		
		<script>
			$(document).ready(function(){
				/*Disable all input type="text" box*/
				$('#form1 input').prop("disabled", true);
                $('#form1 button').hide();

                $('#edit').click(function(){
                $('#form1 input').prop("disabled", false);
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
                                <h3 class="mb-0">{{ __('Edit Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form1" action="{{ route('customer.update', [$customer->id]) }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                    <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ $customer->company_name }}" required autofocus>

                                    @if ($errors->has('company_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                    <input type="text" name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ $customer->industry }}" required>

                                    @if ($errors->has('industry'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('industry') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ $customer->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ $customer->phone }}" required >

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                    <input type="url" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ $customer->website }}" required >

                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                            <input type="text" name="state" id="input-state" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ $address->state }}" required >

                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                            <input type="text" name="city" id="input-city" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ $address->city }}" required >

                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-street">{{ __('Street') }}</label>
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ $address->street }}" required >

                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                            <input type="text" name="country" id="input-country" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ $address->country }}" required >

                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center hide">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
	
        
        @include('layouts.footers.auth')
    </div>

@endsection