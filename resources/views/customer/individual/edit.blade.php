@extends('layouts.app', ['title' => __('Account Management'), 'icon' => 'las la-user-edit'])
@section('content')
@include('users.partials.header', ['title' => __('Individual Account')]) 
@include('master')

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit Individual Account') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customer.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('customer.individual.update') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" value="2" name="account_type">
                            <input type="hidden" name="id" value="{{$customer->id}}">
                            
                            <!-- <h6 class="heading-small text-muted mb-4">{{ __('Account information') }}</h6> -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-first_name">{{ __('Full Name') }}</label>
                                            <input type="text" name="name" id="input-first_name" class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('first_name',$customer->name) }}" required autofocus>

                                            @if ($errors->has('company_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email',$customer->email) }}" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                            <input type="tel" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone',$customer->phone) }}" required >

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
                                            <input type="text" name="profession" id="input-profession" class="form-control form-control-alternative{{ $errors->has('profession') ? ' is-invalid' : '' }}" placeholder="{{ __('Profession') }}" value="{{ old('profession',$customer->profession) }}" required>

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
                                            <select name="industry" id="input-industry" class="form-control form-control-alternative{{ $errors->has('industry') ? ' is-invalid' : '' }}" placeholder="{{ __('Industry') }}" value="{{ old('industry',$customer->industry) }}" required>
                                                <option value="">Select an industry</option>
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
                                      <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                    <input type="text" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" formnovalidate="formnovalidate" value="{{$customer->website}}" >

                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website') }}</strong>
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
                             <div class="col-md-3">
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
                                 <div class="col-md-3">                  
                                <div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-contact_email">{{ __('Email') }}</label>
                                    <input type="email" name="customerContacts[{{$contact->id}}][contact_email]" id="input-contact_email" class="form-control {{ $errors->has('contact_email') ? ' is-invalid' : '' }} standard_price" placeholder="Enter contact email" value="{{old('contact_email',$contact->email)}}">

                                    @if ($errors->has('contact_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact_email') }}</strong>
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