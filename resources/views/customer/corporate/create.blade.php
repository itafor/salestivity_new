@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Account')])
@include('master')

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New  Corporate Account') }}</h3>
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
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                            <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ old('company_name') }}" required autofocus>

                                            @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                            <select name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ old('industry') }}" required>
                                                <option value="">Select an Industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{$industry->id}}">{{ $industry->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('industry'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('industry') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="company_email" name="company_email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                            <input type="tel" name="company_phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required >
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                            <input type="url" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ old('website') }}" required >

                                            @if ($errors->has('website'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('turn_over') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-turn_over">{{ __('Turn Over') }}</label>
                                            <select name="turn_over" id="input-turn_over" class="form-control form-control-alternative{{ $errors->has('turn_over') ? ' is-invalid' : '' }}" placeholder="{{ __('Turn Over') }}" value="{{ old('turn_over') }}" required >
                                                <option value="">Choose an option</option>
                                                <option value="0 - 1,000,000">0 - ₦1,000,000</option>
                                                <option value="1,000,001 - 10,000,000">₦1,000,001 - ₦10,000,000</option>
                                                <option value="10,000,001 - 50,000,000">₦10,000,001 - ₦50,000,000</option>
                                                <option value="50,000,001 - 250,000,000">₦50,000,000 - ₦250,000,000</option>
                                                <option value="250,000,001 - 500,000,000">₦250,000,001 - ₦500,000,000</option>
                                                <option value="500,000,001 - 750,000,000">₦500,000,001 - ₦750,000,000</option>
                                                <option value="750,000,001 - 1,000,000,000">₦750,000,001 - ₦1,000,000,000</option>
                                                <option value="Above 1,000,000,000">Above ₦1,000,000,000</option>
                                            
                                            </select>
                                            @if ($errors->has('turn_over'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('turn_over') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('employee_count') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-employee_count">{{ __('Employee Count') }}</label>
                                            <select name="employee_count" id="input-employee_count" class="form-control form-control-alternative{{ $errors->has('employee_count') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee Count') }}" value="{{ old('employee_count') }}" required >
                                                <option value="">Choose an option</option>
                                                <option value="1-10">1 - 10</option>
                                                <option value="11-50">11 - 50</option>
                                                <option value="51-250">51 - 250</option>
                                                <option value="1001 - 5,000">1,001 - 5,000</option>
                                                <option value="5001 - 10,000">5,001 - 10,000</option>
                                                <option value="10,001 - 50,000">10,001 - 50,001</option>
                                                <option value="50,001 - 100,000">50,001 - 100,000</option>
                                                <option value="Above 100,000">Above 100,000</option>
                                            </select>
                                            @if ($errors->has('employee_count'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('employee_count') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <br><br>

                                <h2>Address</h2>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="country_id">{{ __('Country') }}</label>
                                            <select name="country" id="country_id" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country') }}" required >
                                                <option value="">Select a country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('State') }}</label>
                                            <select name="state" id="state_id" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state') }}" required >
                                                <option value="">Select State</option>
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
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="city_id">{{ __('City') }}</label>
                                            <select name="city" id="city_id" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('street') }}" required >
                                                <option value="">Select City</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
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
                                </div> 
                                    <br><br>
                                <h2>Contact</h2>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                            <select name="title" id="input-title" class="form-control" required >
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
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
                                            <label class="form-control-label" for="surname">{{ __('Surname') }}</label>
                                            <input type="text" name="surname" id="surname" class="form-control form-control-alternative{{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="{{ __('Surname') }}" value="{{ old('surname') }}" required >

                                            @if ($errors->has('surname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('surname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
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
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="email">{{ __('Contact Email') }}</label>
                                            <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact Email') }}" value="{{ old('email') }}" required >

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="phone">{{ __('Contact Phone Number') }}</label>
                                            <input type="tel" name="phone" id="contact_phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact Phone') }}" value="{{ old('phone') }}" required >

                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="field_wrapper">
                                    @csrf
                                    
                                    <!-- Append each new contact form to this div -->
                                    
                                </div>

                                <div class="ml-auto" style="margin:20px;">
                                    <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                    <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add Contact</a>
                                        
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

        // Auto fill unit price when a product has been picked
        function selectCountry(value) {
            $.get('/getstates/' + value, function (data) {
                // console.log(data.states);
                $('#state_id').html("");
                // $('#input-unit').append("");
                jQuery.each(data.states, function (i, val) {
                    $('#state_id').append("<option value='" + val.id + "'>" + val.name + "</option>");
                });
            });
        }

        $('#country_id').change(function () {
            selectCountry($(this).val());
            // $('#input-unit').prop('disabled', false)
        });

        function selectState(value) {
            $.get('/getcities/' + value, function (data) {
                // console.log(data.cities);
                $('#city_id').html("");
                // $('#input-unit').append("");
                jQuery.each(data.cities, function (i, val) {
                    $('#city_id').append("<option value='" + val.id + "'>" + val.name + "</option>");
                });
            });
        }

        $('#state_id').change(function () {
            selectState($(this).val());
            // $('#input-unit').prop('disabled', false)
        });

        
    </script>

@endsection