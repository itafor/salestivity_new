@extends('layouts.app', ['title' => __('Currency Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('Currency')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Currency') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('currency.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                         @include('alerts.errorStatus')
                        <form method="post" action="{{ route('currency.store') }}" autocomplete="off">
                            @csrf
                            
                            <div class="pl-lg-4 pr-lg-4">
                            
                                <div class="row">
                                  

                                        <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('currency_symbol') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="currency_symbol">{{ __('Currency Symbol *') }}</label>
                                            <input type="text" name="currency_symbol" id="currency_symbol" class="form-control form-control-alternative{{ $errors->has('currency_symbol') ? ' is-invalid' : '' }}" placeholder="{{ __('Product currency_symbol') }}" value="{{ old('currency_symbol') }}" required autofocus>

                                            @if ($errors->has('currency_symbol'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('currency_symbol') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                         <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="description">{{ __('Description') }}</label>
                                            <input type="text" name="description" id="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('currency description') }}" value="" required autofocus>

                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
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