@extends('layouts.app', ['title' => __('Target Management'), 'icon' => 'las la-bullseye'])
@section('content')
@include('users.partials.header', ['title' => __('All Targets')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Sales Persons') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('target.create') }}" class="btn-icon btn-tooltip" title="{{ __('Build Target') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="col-11">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Sales Person') }}</th>
                                           
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($targetSalesPersons->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($targetSalesPersons as $target)
                                                <tr>
                                                    <td>{{ $target->salesPerson ? $target->salesPerson->name . ' ' .$target->salesPerson->last_name : '' }}</td>
                                                   <td>
                                                        <span>
                                                           
                                                                <a href="{{route('target.index',[$target->sales_person_id, $target->salesPerson->name])}}" title="View">View {{$target->salesPerson->name}}'s Targets</a>

                                                               
                                                          
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>                    
                        
                    </div>
                </div>
            </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection