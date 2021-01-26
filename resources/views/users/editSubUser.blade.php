@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit User')])   

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
                                <a href="{{ route('allSubUsers') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                        <form method="post" action="{{ route('updateSubUser', [$user]) }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('First Name') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" value="{{ $user->name }}" >

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
                                        <input type="text" name="last_name" id="input-lname" class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Last Name') }}" value="{{ $user->last_name }}">

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
                                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ $user->email }}" readonly>

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
                                            @if(isset($user->role_id))
                                                    @foreach($roles as $role)
                                                        <option {{ $user->roles->id  == $role->id ? 'selected' : ''}} value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                            @else
                                                <option value=""></option>
                                                    <option value="">Select a Role</option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                            @endif
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
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Level') }}</label>
                                       <select name="level" class="form-control" id="level" required>
                                            <option value="{{$user->level}}">{{$user->level}}</option>
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
                                            <select name="report" id="userId" class="form-control" data-toggle="select">
                                                <option value="">No one</option>
                                                @foreach($reportsTo as $report)
                                                    @if($user->reports_to != '')
                                                        <option {{ $user->reportsTo->id  == $report->id ? 'selected' : ''}} value="{{ $report->id }}">{{ $report->name }} {{ $report->last_name }}</option>
                                                    @else    
                                                        <option value="{{ $report->id }}">{{ $report->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select> 

                                            @if ($errors->has('report'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('report') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @if(auth()->user()->id != $user->id)
                                    <div class="col-xl-6">
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                            <select name="status" id="input-status" class="form-control" data-toggle="select" >
                                                <option value="">Select a Status</option>
                                                <option {{ ($user->status === 1 || $user->status === null) ? 'selected' : '' }} value="1">Enable</option>
                                                <option {{ $user->status === 0 ? 'selected' : '' }} value="0">Disable</option>
                                            </select> 
                                            @if ($errors->has('report'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('report') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
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
    <script>

        
    </script>
    
@endsection