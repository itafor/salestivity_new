@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Add User')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('storeuser') }}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="12345" required>
                            <input type="hidden" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm Password') }}" value="12345" required>
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('First Name') }}</label>
                                        <input type="text" name="first_name" id="input-name" class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}" required autofocus>

                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-lname">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" id="input-lname" class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}" required autofocus>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-xl-6">
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
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-role">{{ __('Role') }}</label>
                                        <select name="role_id" id="input-role" class="form-control" data-toggle="select">
                                            <option value="">Select a Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select> 

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('department_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-dept">{{ __('Department') }}</label>
                                            <select name="department_id" id="input-dept" class="form-control" data-toggle="select">
                                                <option value="">Select a Department</option>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select> 

                                            @if ($errors->has('dept'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dept') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('unit_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-unit">{{ __('Unit') }}</label>
                                            <select name="unit_id" id="input-unit" class="form-control" data-toggle="select" disabled>
                                                <option value="">Select a Unit</option>
                                            </select> 

                                            @if ($errors->has('unit_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unit_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('report') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-report">{{ __('Reports To') }}</label>
                                            <select name="report" id="input-report" class="form-control" data-toggle="select">
                                                <option value="0">No one</option>
                                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                                @foreach($reportsTo as $report)
                                                    <option value="{{ $report->id }}">{{ $report->name }}</option>
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
                                                <option value="1">Enabled</option>
                                                <option value="2">Disabled</option>
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
        function selectDeptAjax(value) {
        $.get('/getdept/' + value, function (data) {
            // console.log(data.units);
            $('#input-unit').html("");
            $('#input-unit').append("<option value=''>Select Unit</option>");
            jQuery.each(data.units, function (i, val) {
                $('#input-unit').append("<option value='" + val.id + "'>" + val.name + "</option>");
            });
        });
    }

    $('#input-dept').change(function () {
        selectDeptAjax($(this).val());
        $('#input-unit').prop('disabled', false)
    });
    </script>
    
@endsection