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
                                <h3 class="mb-0">{{ __('My Opportunities') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                 <a href="{{ route('opportunity.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Opportunity') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="rows">

                            <div class="col-xl-6">
                                <div class="form-group dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        All Opportunites
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=1]) }}">All Opportunities</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=2]) }}">Closing this month</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=3]) }}">Closing next month</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=4]) }}">Own By Me</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=5]) }}">Won</a>
                                        <a class="dropdown-item" href="{{ route('opportunity.view', [$id=6]) }}">Lost</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6"></div>
                                            
                            <div class="col-12">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                
                <table class="table table-bordered align-items-center table-flush datatable">
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
                                                        <a href="{{ route('opportunity.show', [$opportunity->id]) }}" title="View">
                                                            <button  class="btn btn-sm text-success">
                                                            <i class="las la-eye"></i>
                                                            </button>
                                                        </a>

                                                         <a onclick="return confirm_delete()"  href="{{route('items.destroy',['opportunity',$opportunity->id])}}" title="Delete"><button class="btn  text-danger">
                                                             <i class="las la-trash"></i>
                                                         </button>
                                                            
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                        <hr>
                        <!-- <h2>Users that reports to me</h2>

                        @include('inc.usersThatReportToMainUser') -->
                    </div>
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection