@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Account')])  

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.corporate.store') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" value="1" name="account_type">
                            <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                    <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ old('company_name') }}" required autofocus>

                                    @if ($errors->has('company_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                    <input type="text" name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ old('industry') }}" required>

                                    @if ($errors->has('industry'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('industry') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required >

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                    <input type="url" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ old('website') }}" required >

                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-turn_over">{{ __('Turn Over') }}</label>
                                    <input type="amount" name="turn_over" id="input-turn_over" class="form-control form-control-alternative{{ $errors->has('turn_over') ? ' is-invalid' : '' }}" placeholder="{{ __('Turn Over') }}" value="{{ old('turn_over') }}" required >

                                    @if ($errors->has('turn_over'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('turn_over') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('employee_count') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-employee_count">{{ __('Employee Count') }}</label>
                                    <input type="amount" name="employee_count" id="input-employee_count" class="form-control form-control-alternative{{ $errors->has('employee_count') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee Count') }}" value="{{ old('employee_count') }}" required >

                                    @if ($errors->has('turn_over'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('employee_count') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                            <input type="text" name="state" id="input-state" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state') }}" required >

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
                                            <input type="text" name="city" id="input-city" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('street') }}" required >

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
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ old('street') }}" required >

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
                                            <input type="text" name="country" id="input-country" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country') }}" required >

                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                            <select name="title" id="input-title" class="form-control" required >
                                                <option value="mr">Mr</option>
                                                <option value="mrs">Mrs</option>
                                                <option value="miss">Miss</option>
                                            </select>

                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('surname') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-country">{{ __('Surname') }}</label>
                                            <input type="text" name="surname" id="input-surname" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Surname') }}" value="{{ old('country') }}" required >

                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Contact Name') }}</label>
                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required >

                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="contact_email">{{ __('Contact Email') }}</label>
                                            <input type="email" name="contact_email" id="contact_email" class="form-control form-control-alternative{{ $errors->has('contact_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact Email') }}" value="{{ old('contact_email') }}" required >

                                            @if ($errors->has('contact-_mail'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('contact_phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-number">{{ __('Contact Phone Number') }}</label>
                                            <input type="tel" name="contact_phone" id="contact_phone" class="form-control form-control-alternative{{ $errors->has('contact_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact Phone') }}" value="{{ old('contact_phone') }}" required >

                                            @if ($errors->has('contact_phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact_phone') }}</strong>
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