@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-folder-plus'])
@section('content')
@include('users.partials.header', ['title' => __('Corporate Account')])
@include('master')

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit Corporate Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.corporate.update') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" value="1" name="account_type">
                            <input type="hidden" name="id" value="{{$customer->id}}">

                            <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-company">{{ __('Company Name') }}</label>
                                            <input type="text" name="company_name" id="input-company" class="form-control form-control-alternative{{ $errors->has('company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Company Name') }}" value="{{ old('company_name',$customer->name) }}" required autofocus>

                                            @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                             
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="company_email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email',$customer->email) }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('company_phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-company_phone">{{ __('Phone') }}</label>
                                            <input type="tel" name="company_phone" id="input-company_phone" class="form-control form-control-alternative{{ $errors->has('company_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone',$customer->phone) }}" required >
                                            @if ($errors->has('company_phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                

                                <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                            <input type="text" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{$customer->website}}" >

                                            @if ($errors->has('website'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>



                                 
                                </div>
                                




                                <div class="row">
                                       <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('industry') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-industry">{{ __('Industry') }}</label>
                                            <select name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ old('industry') }}" required>
                                                <option value="">Select an Industry</option>
                                                @foreach(getIndustries() as $industry)
                                                    <option value="{{$industry->id}}"
                                                    {{$industry->id == $customer->industry ? 'selected' : ''}}>
                                                    {{ $industry->name }}
                                                </option>
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
                                        <div class="form-group{{ $errors->has('employee_count') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-employee_count">{{ __('Employee Count') }}</label>
                                            <select name="employee_count" id="input-employee_count" class="form-control form-control-alternative{{ $errors->has('employee_count') ? ' is-invalid' : '' }}" placeholder="{{ __('Employee Count') }}" value="{{ old('employee_count') }}" required >
                                                <option value="{{$customer->employee_count}}">{{$customer->employee_count}}</option>
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
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('turn_over') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-turn_over">{{ __('Turn Over') }}</label>
                                            <select name="turn_over" id="input-turn_over" class="form-control form-control-alternative{{ $errors->has('turn_over') ? ' is-invalid' : '' }}" placeholder="{{ __('Turn Over') }}" value="{{ old('turn_over') }}" required >
                                                <option value="{{$customer->turn_over}}">{{$customer->turn_over}}</option>
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
                            

                                <h2>Address:</h2>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="country_id">{{ __('Country') }}</label>
                                            <select name="country" id="country_id" class="form-control form-control-alternative{{ $errors->has('country') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country') }}" required >
                                                <option value="">Select a country</option>
                                                @foreach(getCountries() as $country)
                                                    <option value="{{ $country->id }}"
                                             {{$country->id == $address->country ? 'selected' : ''}}
                                                        >{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('State') }}</label>
                                            <select name="state" id="state_id" class="form-control form-control-alternative{{ $errors->has('state') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state') }}" required >
                                                <option value="">Select State</option>
                                                 @foreach(getStates() as $state)
                                                    <option value="{{ $state->id }}"
                                             {{$state->id == $address->state ? 'selected' : ''}}
                                                        >{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                <!-- </div>

                                <div class="row"> -->
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="city_id">{{ __('City') }}</label>
                                            <select name="city" id="city_id" class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('street') }}" required >
                                                <option value="">Select City</option>
                        <option value="{{ $cityId }}" selected="true">{{ $cityName }}</option>
                                            </select>
                                            @if ($errors->has('city'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-street">{{ __('Street') }}</label>
                                            <input type="text" name="street" id="input-street" class="form-control form-control-alternative{{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Street') }}" value="{{ old('street',$address->street)}}" required >

                                            @if ($errors->has('street'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('street') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                   
                          <h2>{{ __('Contacts:') }}</h2>
                           @if ($customer->contacts->count() > 0)
                                    @foreach ($customer->contacts as $contact)
                                     @if($customer->email != $contact->email && $contact->title !=null )
                                     <div style="float:right;cursor: pointer;"><a onclick="deleteData('contact','destroy',{{$contact->id}})" class="btn btn-danger btn-sm text-white" title="Delete Contact">
                                        <i class="fa fa-trash" ></i> Delete
                                     </a></div>
                                    <div style="clear:both"></div>
                                   
                    <div class="row">
                         <div class="col-md-2">
                        <div class="form-group{{ $errors->has('contact_title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-property_type">{{ __('Title') }}</label>
                                    <select name="customerContacts[{{$contact->id}}][contact_title]"  class="form-control">
                                        <option value="{{$contact->title}}">{{$contact->title}}</option>
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
                             <div class="col-md-2">
                                <div class="form-group{{ $errors->has('contact_surname') ? ' has-danger' : '' }} ">
                                    <label class="form-control-label" for="input-category">{{ __('Surname') }}</label>

                                    <input type="text" name="customerContacts[{{$contact->id}}][contact_surname]" id="input-contact_surname" class="form-control {{ $errors->has('contact_surname') ? ' is-invalid' : '' }}" placeholder="Enter surname" value="{{old('contact_surname',$contact->surname)}}">
                                    @if ($errors->has('contact_surname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_surname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-contact_name">Other Names</label>
                                    <input type="text" name="customerContacts[{{$contact->id}}][contact_name]" id="input-contact_name" class="form-control {{ $errors->has('contact_name') ? ' is-invalid' : '' }} contact_name" placeholder="Enter other names" value="{{old('contact_name',$contact->name)}}">
                                    
                                    @if ($errors->has('contact_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                                </div>
                                 <div class="col-md-2">                  
                                <div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-contact_email">{{ __(' Email') }}</label>
                                    <input type="email" name="customerContacts[{{$contact->id}}][contact_email]" id="input-contact_email" class="form-control {{ $errors->has('contact_email') ? ' is-invalid' : '' }} standard_price" placeholder="Enter contact email" value="{{old('contact_email',$contact->email)}}">

                                    @if ($errors->has('contact_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                  <div class="col-md-2">                  
                                <div class="form-group{{ $errors->has('alternative_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-alternative_email">{{ __('Alternaive Email') }}</label>
                                    <input type="email" name="customerContacts[{{$contact->id}}][alternative_email]" id="input-alternative_email" class="form-control {{ $errors->has('alternative_email') ? ' is-invalid' : '' }} standard_price" placeholder="Enter contact email" value="{{old('alternative_email',$contact->alternative_email)}}">

                                    @if ($errors->has('alternative_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('alternative_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group{{ $errors->has('rent_commission') ? ' has-danger' : '' }} ">
                                    <label class="form-control-label" for="input-contact_phone">{{ __('Phone') }}</label>
                                    <input type="tel"  name="customerContacts[{{$contact->id}}][contact_phone]" id="input-contact_phone" class="form-control {{ $errors->has('contact_phone') ? ' is-invalid' : '' }} contact_phone" placeholder="Enter contact phone" value="{{old('contact_phone',$contact->phone)}}">

                                    @if ($errors->has('contact_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                              @endforeach
                                @else
                              <h4>No contact record found</h4>
                        @endif

                            </div>

                                <div style="clear:both"></div>
                                <div id="container">
                                </div>   
                                <div class="form-group" style="margin-top: 20px;">
                                    <button type="button" id="addMore" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i>  Add More</button>
                                </div>   


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
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