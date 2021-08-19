@extends('layouts.app', ['title' => __('Currency Management'), 'icon' => 'las la-edit'])
@section('content')
@include('users.partials.header', ['title' => __('Currency')]) 
		
 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
               


<div class="card">
  <div class="card-header">
    <div class="float-left">Edit currency</div>
    <div class="float-right">
        <a href="{{route('currency.index')}}">Back to List</a>
    </div>
  </div>
  <div class="card-body">
 <form method="PATCH" action="{{ route('currency.update', [$currency->id]) }}" id="form1" autocomplete="off">
                            @csrf
                            <div class="pl-lg-4">
                               
                                <div class="row">
                                 
                                  <input type="hidden" name="currency_symbol" id="currency_symbol" class="form-control form-control-alternative{{ $errors->has('currency_symbol') ? ' is-invalid' : '' }}" placeholder="{{ __('currency currency_symbol') }}" value="{{$currency->id }}" required >

                                      <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('currency_symbol') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="currency_symbol">{{ __('currency currency_symbol') }}</label>
                                            <input type="text" name="currency_symbol" id="currency_symbol" class="form-control form-control-alternative{{ $errors->has('currency_symbol') ? ' is-invalid' : '' }}" placeholder="{{ __('currency currency_symbol') }}" value="{{$currency->currency_symbol }}" required >

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
                                            <input type="text" name="description" id="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('currency description') }}" value="{{ $currency->description }}" required autofocus>

                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                 
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