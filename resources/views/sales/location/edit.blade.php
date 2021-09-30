@extends('layouts.app', ['title' => __('Location Management'), 'icon' => 'las la-map-marker-alt'])
@section('content')
@include('users.partials.header', ['title' => __('Add Sales Location')])

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Location') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.location.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.location.update') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="location_id" value="{{$location->id}}">
                            <h6 class="heading-small text-muted mb-4">{{ __('Sales Location information') }}</h6>
                            <div class="pl-lg-4 pr-lg-4">
                                <div class="row">
                                   
                                    <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('country_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="country_id">{{ __('Country') }}</label>
                                            <select name="country_id" id="country_id" class="form-control form-control-alternative border-input {{ $errors->has('country_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Country') }}" value="{{ old('country_id') }}" >
                                                <option value="">Select Country</option>
                                                
                                                 @foreach(getCountries() as $country)
                                                    <option value="{{ $country->id }}"
                                             {{$country->id == $location->country_id ? 'selected' : ''}}
                                                        >{{ $country->name }}</option>
                                                @endforeach 
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('country_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                         <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('state_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="state_id">{{ __('State') }}</label>
                                            <select name="state_id" id="state_id" class="form-control form-control-alternative border-input {{ $errors->has('state_id') ? ' is-invalid' : '' }}" placeholder="{{ __('State') }}" value="{{ old('state_id') }}" >
                                                <option value="">Select State</option>
                                                     @foreach(getStates() as $state)
                                                    <option value="{{ $state->id }}"
                                             {{$state->id == $location->state_id ? 'selected' : ''}}
                                                        >{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('state_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('state_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                     <div class="col-xl-4">
                                        <div class="form-group{{ $errors->has('city_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="city_id">{{ __('City') }}</label>
                                            <select name="city_id" id="city_id" class="form-control form-control-alternative border-input {{ $errors->has('city_id') ? ' is-invalid' : '' }}" placeholder="{{ __('City') }}" value="{{ old('city_id') }}" >
                                                <option value="">Select City</option>
                                                    <option value="{{ $city->id }}" selected="true">{{ $city->name }}</option>
                                            </select>
                                            @if ($errors->has('city_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="row">
                               
                                   

                                     <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('location') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="location">{{ __('Location') }}</label>
                                            <input type="text" name="location" id="location" class="form-control form-control-alternative{{ $errors->has('location') ? ' is-invalid' : '' }}" placeholder="{{ __('Location') }}" value="{{ old('location', $location->location) }}" required>
                                            @if ($errors->has('location'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('location') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="address">{{ __('Address') }}</label>
                                            <input type="text" name="address" id="address" class="form-control form-control-alternativeo./j{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address') }}" value="{{ old('address', $location->address) }}" required>
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
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