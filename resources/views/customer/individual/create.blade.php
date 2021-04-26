@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-user-plus'])
@section('content')
@include('users.partials.header', ['title' => __('Individual Account')]) 
@include('master')

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Individual Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.individual.store') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" value="2" name="account_type">
                            <!-- <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6> -->
                            <div class="pl-lg-4 pr-lg-4">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-first_name">{{ __('First Name') }}</label>
                                            <input type="text" name="first_name" id="input-first_name" class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required autofocus>

                                            @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-last_name">{{ __('Last Name') }}</label>
                                            <input type="text" name="last_name" id="input-last_name" class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required autofocus>

                                            @if ($errors->has('last_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                            <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required >

                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('profession') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-profession">{{ __('Profession') }}</label>
                                            <input type="text" name="profession" id="input-profession" class="form-control form-control-alternative{{ $errors->has('profession') ? ' is-invalid' : '' }}" placeholder="{{ __('Profession') }}" value="{{ old('profession') }}" required>

                                            @if ($errors->has('profession'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('profession') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                            <select name="industry" id="input-industry" class="form-control form-control-alternative border-input{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ old('industry') }}" required>
                                                <option value="">Select an industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('industry'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('industry') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website">{{ __('Website') }} (Optional)</label>
                                    <input type="text" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="Type a url"  value="">

                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </fieldset
                        >  
                        <fieldset>
                                
                               <h2>Address:</h2>
                                <div class="row">
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
                                </div>

                                <div class="row">
                                 
                                    <div class="col-md-12">
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
                                </div> 
                            </fieldset>
                            <fieldset>
                                <h2>{{ __('Contacts:') }}</h2>
                                <div class="row">
                                     <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('contact_title') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-property_type">{{ __('Title') }}</label>
                                                <select name="contacts[112211][contact_title]"  class="form-control">
                                                    <option value="">Select title</option>
                                                    <option value="Mr.">Mr.</option>
                                                    <option value="Mrs.">Mrs.</option>
                                                    <option value="Miss">Miss</option>
                                                    
                                                </select>

                                                @if ($errors->has('contact_title'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact_title') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>
                                         <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('contact_surname') ? ' has-danger' : '' }} ">
                                                <label class="form-control-label" for="input-category">{{ __('Surname') }}</label>

                                                <input type="text" name="contacts[112211][contact_surname]" id="input-contact_surname" class="form-control {{ $errors->has('contact_surname') ? ' is-invalid' : '' }}" placeholder="Enter surname" value="{{old('contact_surname')}}">
                                                @if ($errors->has('contact_surname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact_surname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-contact_name">Other Names</label>
                                                <input type="text" name="contacts[112211][contact_name]" id="input-contact_name" class="form-control {{ $errors->has('contact_name') ? ' is-invalid' : '' }} contact_name" placeholder="Enter other names" value="{{old('contact_name')}}">
                                                
                                                @if ($errors->has('contact_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div> 
                                            </div>
                                             <div class="col-md-4">                  
                                            <div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-contact_email">{{ __('Email') }}</label>
                                                <input type="email" name="contacts[112211][contact_email]" id="input-contact_email" class="form-control {{ $errors->has('contact_email') ? ' is-invalid' : '' }} standard_price" placeholder="Enter contact email" value="{{old('contact_email')}}">

                                                @if ($errors->has('contact_email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact_email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('rent_commission') ? ' has-danger' : '' }} ">
                                                <label class="form-control-label" for="input-contact_phone">{{ __('Phone') }}</label>
                                                <div class="input-group mb-3">
                                                    <!-- <div class="input-group-prepend">
                                                        <span class="input-group-text country-code" id="basic-addon1">+{{$getCountry->phonecode}}</span>
                                                    </div> -->
                                                    <input type="tel"  name="contacts[112211][contact_phone]" id="input-contact_phone" class="form-control {{ $errors->has('contact_phone') ? ' is-invalid' : '' }} contact_phone" placeholder=" 8090000000" value="{{old('contact_phone')}}">
                                                </div>
                                                @if ($errors->has('contact_phone'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact_phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div style="clear:both"></div>
                                <div id="container" class="pl-lg-4 pr-lg-4">
                                </div>   
                                
                                <div class="form-group pl-lg-4 pr-lg-4" style="margin-top: 20px;">
                                    <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
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