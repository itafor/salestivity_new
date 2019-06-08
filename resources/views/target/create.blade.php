@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Add Target')])

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add New Target') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('target.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('target.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Target information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('opportunity_name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-opportunity">{{ __('Opportunity Name') }}</label>
                                            <input type="text" name="opportunity_name" id="input-opportunity" class="form-control form-control-alternative{{ $errors->has('opportunity_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Opportunity Name') }}" value="{{ old('opportunity_name') }}" required>

                                            @if ($errors->has('opportunity_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('opportunity_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('account') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-account">{{ __('Account') }}</label>
                                            <select name="account_id" id="account" class="form-control form-control-alternative{{ $errors->has('account_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Account') }}" value="{{ old('account_id') }}" >
                                                <option value="">Select Account</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('account_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('account_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('stage') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-stage">{{ __('Stage') }}</label>
                                            <select name="stage" id="stage" class="form-control form-control-alternative{{ $errors->has('stage') ? ' is-invalid' : '' }}" placeholder="{{ __('Stage') }}" value="{{ old('stage') }}" required >
                                                <option value="">Select a stage</option>
                                                <option value="Qualification">Qualification</option>
                                                <option value="Needs Analysis">Needs Analysis</option>
                                            </select>
                                            @if ($errors->has('stage'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('stage') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('contact') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-contact">{{ __('Contact') }}</label>
                                            <select name="contact" id="contact" class="form-control form-control-alternative{{ $errors->has('contact') ? ' is-invalid' : '' }}" placeholder="{{ __('Contact') }}" value="{{ old('contact') }}" disabled>
                                                <option value="">Select Contact</option>
                                            </select>
                                            @if ($errors->has('contact'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('probability') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-probability">{{ __('Probability(%)') }}</label>
                                            <input type="text" name="probability" id="input-probability" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}" placeholder="{{ __('Probability') }}" value="{{ old('probability') }}">

                                            @if ($errors->has('probability'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('probability') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-amount">{{ __('Amount(₦)') }}</label>
                                            <input type="text" name="amount" id="input-amount" class="form-control form-control-alternative{{ $errors->has('probability') ? ' is-invalid' : '' }}" placeholder="{{ __('Amount') }}" value="{{ old('amount') }}">

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('initiation_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-initiation_date">{{ __('Initiation Date') }}</label>
                                            <input type="date" name="initiation_date" id="input-initiation_date" class="form-control form-control-alternative{{ $errors->has('initiation_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Initiation Date') }}" value="{{ old('initiation_date') }}" required>

                                            @if ($errors->has('initiation_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('initiation_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('closure_date') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-closure_date">{{ __('Expected Closure Date') }}</label>
                                            <input type="date" name="closure_date" id="input-closure_date" class="form-control form-control-alternative{{ $errors->has('closure_date') ? ' is-invalid' : '' }}" placeholder="{{ __('Expected Closure Date') }}" value="{{ old('closure_date') }}" required>

                                            @if ($errors->has('closure_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('closure_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('owner') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-owner">{{ __('Owner') }}</label>
                                            <input type="text" name="owner" id="input-owner" class="form-control form-control-alternative{{ $errors->has('owner') ? ' is-invalid' : '' }}" placeholder="{{ __('Owner') }}" value="{{ old('owner') }}">

                                            @if ($errors->has('owner'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('owner') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <br><br><br>
                                <div class="field_wrapper">
                                    
                                </div>

                                <div class="ml-auto" style="margin:20px;">
                                    <!-- <input type="text" name="field_name[]" value="" class="form-control"/> -->
                                    <a href="javascript:void(0);" class="add_button btn btn-primary" id="addContact"><i class="fa fa-plus-circle"></i> Add Product</a>
                                        
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