@extends('layouts.app', ['title' => __('Opportunities')])
@section('content')
@include('users.partials.header', ['title' => __('Opportunities')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Opportunities') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('opportunity.create') }}" class="btn btn-sm btn-primary">{{ __('Add Opportunity') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="form-group dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        Lost
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=1]) }}">All Opportunities</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=2]) }}">Closing this month</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=3]) }}">Closing next month</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=4]) }}">My Opportunities</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=5]) }}">Won</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=6]) }}">Lost</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6"></div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">{{ __('Account') }}</th>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Owner') }}</th>
                                        <th scope="col">{{ __('Amount') }}</th>
                                        <th scope="col">{{ __('Stage') }}</th>
                                        <th scope="col">{{ __('Date Initiated') }}</th>
                                        <th scope="col">{{ __('Estimated Closure Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($opportunities as $opportunity)
                                        <tr>
                                        
                                            <td>{{ $opportunity->customer->name }}</td>
                                            <td>{{ $opportunity->name }}</td>
                                            <td>{{ $opportunity->owner }}</td>
                                            <td>{{ $opportunity->amount }}</td>
                                            <td>{{ $opportunity->stage }}</td>
                                            <td>{{ $opportunity->initiation_date }}</td>
                                            <td>{{ $opportunity->closure_date }}</td>
                                            <td> 
                                                <a href="{{ route('opportunity.show', [$opportunity->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                <!-- <a href="{{-- route('billing.renewal.manage', [$renewal->id]) }}" class="btn btn-sm btn-primary">{{ __('Manage') --}}</a> -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
  </div>
@endsection