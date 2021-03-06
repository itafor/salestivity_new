@extends('layouts.app', ['title' => __('Opportunities'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Opportunities')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0  mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('My Opportunites') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                               <a href="{{ route('opportunity.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Opportunity') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="form-group dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Closing Next Month
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=1]) }}">All Opportunities</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=2]) }}">Closing this month</a>
                                      
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=4]) }}">Own By Me</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=5]) }}">Won</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=6]) }}">Lost</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=7]) }}">Open</a>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6"></div>
                        </div>

               @include('opportunity.opportunity_lists')
                        

                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
  </div>
@endsection