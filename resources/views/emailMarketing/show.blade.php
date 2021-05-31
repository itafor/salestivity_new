@extends('layouts.app', ['title' => __('Email Marketing Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('List mail')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Mails') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('email.marketing.list') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($mail))
                       
                       {!! $mail->message !!}
                       @else
                       <span>No mail found</span>
                       @endif
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection