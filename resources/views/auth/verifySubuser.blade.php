@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
   <div class="header bg-solid-custom py-7 py-lg-8">
    <div class="container">
        <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-dark">{{ __('Verify Your Email Address') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>-->
</div>

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="cardcard-custom bg-secondary shadow">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Verify Your Email Address') }}</small>
                        </div>
                        <div>
                            @if (session('emailResent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif
                            
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            
                            @if (Route::has('verification.resend'))
                                {{ __('If you did not receive the email') }}, <a href="{{ route('subuser.resend.emaillink') }}">{{ __('click here to request another') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
