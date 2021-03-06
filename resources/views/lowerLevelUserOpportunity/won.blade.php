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
                                <h3 class="mb-0">{{$user->name}} {{$user->last_name}}'s {{ __('Opportunities') }}</h3>
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
                                        Won
                                    </button>
                                      <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=1, $user->id]) }}">All Opportunities</a>
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=2, $user->id]) }}">Closing this month</a>
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=3, $user->id]) }}">Closing next month</a>
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=4, $user->id]) }}">Own By {{$user->name}} {{$user->last_name}}</a>
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=5, $user->id]) }}">Won</a>
                                        <a class="dropdown-item" href="{{ route('lower.level.useropportunity.view', [$id=6, $user->id]) }}">Lost</a>
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
                                        <th scope="col">{{ __('Action') }}</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @if($opportunities->isEmpty())
                                    <tr>
                                        <td colspan="8" style="text-align: center">
                                            <h3>No data available</h3>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($opportunities as $opportunity)
                                        <tr>
                                        
                                           <td>{{ $opportunity->customer ? $opportunity->customer->name : 'N/A'}}</td>
                                                <td>{{ $opportunity->name }}</td>
                                                 <td>{{ $opportunity->owner ? $opportunity->owner->name .' '.$opportunity->owner->last_name : 'N/A'  }}</td>
                                                 <td>&#8358;{{ number_format($opportunity->amount,2) }} </td>
                                            <td>
                                                    <a href="{{ route('opportunity.show', [$opportunity->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                    <a href="{{-- route('billing.renewal.manage', [$renewal->id]) }}" class="btn btn-sm btn-primary">{{ __('Manage') --}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
<hr>

                         <h2>Users that reports to {{$user->name}} {{$user->last_name}}</h2>

                        @include('inc.usersThatReportToSubusers')
                    </div>
                </div>
            </div>
        </div>

    @include('layouts.footers.auth')
  </div>
@endsection