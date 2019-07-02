@extends('layouts.app', ['title' => __('User Management')])
@section('content')
@include('users.partials.header', ['title' => __('Edit Contact')]) 

<div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('View Product') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button id="edit" class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.contact.update', $contact->id )}}" method="post" id="form1">
                        @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                        <input type="text" name="contact_title" id="input-title"  value="{{ $contact->title }}" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" required >
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('contact_email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                        <input type="text" name="contact_email" id="input-email" value="{{ $contact->email }}" class="form-control form-control-alternative{{ $errors->has('contact_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required >
                                        @if ($errors->has('contact_email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row"> 
                                <div class="col-xl-6"> 
                                    <div class="form-group{{ $errors->has('contact_phone') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-phone">Phone</label>
                                        <input type="number" name="contact_phone" value="{{ $contact->phone }}" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" required >

                                        @if ($errors->has('contact_phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('contact_surname') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-surname">{{ __('Surname') }}</label>
                                        <input type="text" name="contact_surname" value="{{ $contact->surname }}" id="input-surname" class="form-control form-control-alternative{{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="{{ __('Surname') }}" required >
                                        @if ($errors->has('contact_surname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_surname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                <div class="col-xl-6">
                                    <div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('First Name') }}</label>
                                        <input type="text" name="contact_name" value="{{ $contact->name }}" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('First Name') }}" required >
                                        @if ($errors->has('contact_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div> 
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                        
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
    <script>
        $(document).ready(function(){
            /*Disable all input type="text" box*/
            $('#form1 input').prop("disabled", true);
            $('#form1 button').hide();

            $('#edit').click(function(){
            $('#form1 input').prop("disabled", false);
            $('#form1 button').show();
            $('#edit').toggle();
            $('#addContact').css("display","block");
            })
            
        });
	</script>   

@endsection