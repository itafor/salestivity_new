@extends('layouts.app', ['title' => __('Location')])
@section('content')
@include('users.partials.header', ['title' => __('All Location')]) 

      
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Sales Location') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.location.create') }}" class="btn btn-sm btn-primary">{{ __('Add Location') }}</a>
                            </div>
                        </div>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table align-items-center table-bordered" >
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Location') }}</th>
                                    <th scope="col">{{ __('Country') }}</th>
                                    <th scope="col">{{ __('State') }}</th>
                                    <th scope="col">{{ __('City') }}</th>
                                    <th scope="col">{{ __('Address') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($locations as $location)
                               <tr>
                                    <td>{{ $location->location }}</td>
                                    <td>{{ $location->country->country_name }}</td>
                                    <td>{{ $location->state->name }}</td>
                                    <td>{{ $location->city->name }}</td>
                                    <td>{{ $location->address }}</td>
                               <td>   
                                    <span>
                                        <div class="col-4 text-right">
                                            <a href="{{ route('sales.location.show', [$location->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                            
                                        </div>
                                    </span>
                                </td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection