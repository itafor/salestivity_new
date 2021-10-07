@extends('layouts.zeus_layout', ['title' => __('Plans Management')])
@section('content')
@include('zeus.partials.header', ['title' => __('Plans')])
    <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Create New Plan') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('admin.plans.index')}}" class="btn btn-sm btn-primary">{{ __('Back To List') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                     <form method="post" action="{{ route('admin.plans.update') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{$plan->id}}">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Name of Plan') }}</label>
                                    <input type="text" name="name"
                                           class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="Name" value="{{old('name', $plan->name)}}" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Price') }}</label>
                                    <input type="number" name="amount"
                                           class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                           placeholder="Name" value="{{old('amount', $plan->amount)}}" required>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                    @endif
                                </div>
                             
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('number_of_subusers') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Number Sub Users') }}</label>
                                    <input type="number" name="number_of_subusers"
                                           class="form-control form-control-alternative{{ $errors->has('number_of_subusers') ? ' is-invalid' : '' }}"
                                           placeholder="Number of  Sub Users" value="{{old('number_of_subusers', $plan->number_of_subusers)}}" required>
                                    @if ($errors->has('number_of_subusers'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('number_of_subusers') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('number_of_accounts') ? ' has-danger' : '' }} col-6">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Number Accounts') }}</label>
                                    <input type="text" name="number_of_accounts"
                                           class="form-control form-control-alternative{{ $errors->has('number_of_accounts') ? ' is-invalid' : '' }}"
                                           placeholder="Number of Accounts" value="{{old('number_of_accounts', $plan->number_of_accounts)}}" required>
                                    @if ($errors->has('number_of_accounts'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('number_of_accounts') }}</strong>
                                            </span>
                                    @endif
                                </div>
                               
                            </div>
                            <div class="row">
                                   <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-12">
                                    <label class="form-control-label"
                                           for="input-tenant">{{ __('Description (Optional)') }}</label>
                                    <textarea name="description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}">{{$plan->description}}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div style="clear:both"></div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save Plan Data') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>

@endsection