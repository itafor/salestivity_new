@extends('layouts.app', ['title' => __('Email Marketing Management'), 'icon' => 'las la-cart'])
@section('content')
@include('users.partials.header', ['title' => __('Send new mail')])  

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Send mail to customers') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('email.marketing.list') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                <form autocomplete="off" action="{{route('email.marketing.send')}}" method="POST">
                    @csrf
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Subject:</label>
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter subject" required>
                </div>
                <div class="mb-3">
               <textarea name="message" class="content" id="message" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary"> Send </button>
                </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@endsection