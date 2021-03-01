@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-suitcase'])
@section('content')
@include('users.partials.header', ['title' => __('View Account')]) 
@include('master')

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
                                <button id="edit" class="btn-icon btn-tooltip" title="{{ __('Edit') }}"><i class="las la-edit"></i></button>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form1" action="{{ route('customer.corporate.update', [$customer->id]) }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6>
                            <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                        <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ $customer->corporate->company_name }}" required autofocus>

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
                                        <input type="text" name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ $customer->corporate->industry }}" required>

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
                                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ $customer->corporate->email }}" required>

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
                                        <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ $customer->corporate->phone }}" required >

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
                                        <input type="url" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ $customer->corporate->website }}" required >

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
                                            <option value="{{ $customer->corporate->turn_over }}">{{ $customer->corporate->turn_over }}</option>
                                            <option value="0 - 50,000">0 - ₦50,000</option>
                                            <option value="51,000 - 100,000">₦51,000 - ₦100,000</option>
                                            <option value="101,000 - 150,000">₦101,000 - ₦150,000</option>
                                            <option value="151,000 - 250,000">₦151,000 - ₦250,000</option>
                                            <option value="251,000 - 500,000">₦251,000 - ₦500,000</option>
                                            <option value="501,000 - 750,000">₦501,000 - ₦750,000</option>
                                            <option value="751,000 - 1,000,000">₦751,000 - ₦1,000,000</option>
                                            <option value="Above 1,000,000">Above ₦1,000,000</option>
                                        
                                        </select>
                                        @if ($errors->has('turn_over'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('turn_over') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('employee_count') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-employee_count">{{ __('Employee Count') }}</label>
                                        <select name="employee_count" id="input-employee_count" class="form-control form-control-alternative{{ $errors->has('employee_count') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee Count') }}" value="{{ old('employee_count') }}" required >
                                            <option value="{{ $customer->corporate->employee_count }}">{{ $customer->corporate->employee_count }}</option>
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
                            <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-country">{{ __('Country') }}</label>
                                            <select name="country" id="country_id" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" required >
                                                <option value="{{ $address->country }}">{{ $address->getCountry($address->country) }}</option>
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
                                            <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                            <select type="text" name="state" id="state_id" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ $address->getState($address->state) }}" required >
                                                <option value="{{ $address->state }}">{{ $address->getState($address->state) }}</option>
                                                
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
                                            <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                            <select name="city" id="city_id" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ $address->city }}" required >
                                                <option value="{{ $address->city }}">{{ $address->getCity($address->city) }}</option>
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
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ $address->street }}" required >

                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>  
                                
                            <input type="hidden" value="{{ $customer->id }}" name="customer_id[]">
                            <div class="text-center hide">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>
					<br><br>
					<div class="col-8">
						<h2 class="mb-0">{{ __('Contacts') }}</h2>
					</div>
					
					<div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Surname') }}</th>
                                    <th scope="col">{{ __('Firstname') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                  <tr>
                                      <td>{{ $contact->title }}</td>
                                      <td>{{ $contact->surname }}</td>
                                      <td>{{ $contact->name }}</td>
                                      <td>{{ $contact->phone }}</td>
                                      <td>{{ $contact->email }}</td>
                                    <td>
                                        <div class="btn-group-justified text-center" role="group">
                                            <div class="btn-group" role="group">
                                                <a href="{{-- route('customer.contact.show', [$customer->id]) --}}"style="margin-right: 10px;" class="btn-sm btn btn-success">{{ __('View') }}</a>
                                            </div>
                                            <div class="btn-group" role="group">
                                                <form action="{{-- route('customer.corporate.destroy', [$customer->id]) --}}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                    @csrf
                                                    
                                                        <button type="submit"  class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                                  </tr>
                            </tbody>
                        </table>    
                    </div>
                    <!-- <div class="row"> -->
                        <div class="col-xl-6" style="margin:20px;">
                            <form action="{{ route('customer.corporate.saveContacts', [$customer->id]) }}" method="post">
                                <div class="field_wrapper">
                                    @csrf
                                    <input type="hidden" value="{{ $customer->id }}" name="customer_id[]">
                                    <!-- Append each new contact form to this div -->
                                    
                                </div>
                                <div class="text-center hide">
                                    <button type="submit" class="btn btn-success mt-4" id="saveContact" style="display:none">{{ __('Save') }}</button>
                                </div>
                            </form>
                            
                        </div>    
                    <!-- </div> -->
                    <div class="ml-auto" style="margin:20px;">
                        <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                        <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add Contact</a>
                            
                    </div>
                </div>
            </div>
			<br><br><br>
        </div>
					

	
        
        @include('layouts.footers.auth')
    </div>

@endsection