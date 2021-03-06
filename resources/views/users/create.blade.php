@extends('layouts.app', ['title' => __('User Management'), 'icon' => 'las la-users-cog'])

@section('content')
    @include('users.partials.header', ['title' => __('Add User')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary ">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('allSubUsers') }}" class="btn-icon btn-tooltip" title="{{ __('Back to List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                      @include('alerts.errorStatus')
                        
             @include('alerts.messages')
            
                        <form method="post" action="{{ route('storeuser') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="password" required>
                            <input type="hidden" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm Password') }}" value="password" required>
                           
                            <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('First Name') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-lname">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" id="input-lname" class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
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
                            </div>
                                
                            <div class="row">
                                
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-role">{{ __('Role') }}</label>
                                        @if($roles->isEmpty())
                                            <select name="role_id" id="input-role" class="form-control" data-toggle="select">
                                                <option value="">No role created</option>
                                            </select>
                                        @else
                                            <select name="role_id" id="input-role" class="form-control" data-toggle="select">
                                            <option value="">Select a Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            @endif
                                        </select> 

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('level') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-level">Level: (1 is the highest level, followed by 2 etc.)</label>
                                        <select name="level" class="form-control" id="level">
                                            <option value="">Select Level</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>

                                        @if ($errors->has('level'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('level') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('report') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-report">{{ __('Reports To') }}</label>
                                            <select name="report" id="userId" class="form-control" data-toggle="select" required>
                                                <option value="">No one</option>
                                                @foreach($reportsTo as $report)
                                                    <option value="{{ $report->id }}">{{ $report->name }} {{ $report->last_name }} ({{$report->level}})</option>
                                                @endforeach
                                            </select> 

                                            @if ($errors->has('report'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('report') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                            <select name="status" id="input-status" class="form-control" data-toggle="select">
                                                <option value="">Status</option>
                                                <option value="1">Enable</option>
                                                <option value="0">Disable</option>
                                            </select> 
                                            @if ($errors->has('report'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('report') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    
                            
                                
                                
                                <!-- <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="12345" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm Password') }}" value="12345" required>
                                </div> -->

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

        
    </script>
    
@endsection