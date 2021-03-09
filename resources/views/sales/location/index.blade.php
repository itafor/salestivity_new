@extends('layouts.app', ['title' => __('Location Management'), 'icon' => 'las la-map-marker-alt'])
@section('content')
@include('users.partials.header', ['title' => __('All Location')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Sales Location') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.location.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Sales Location') }}"><i class="las la-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                        

                            <div class="table-responsive">
                                <table class="table table-bordered align-items-center table-bordered datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Location') }}</th>
                                            <th scope="col">{{ __('Country') }}</th>
                                            <th scope="col">{{ __('State') }}</th>
                                            <th scope="col">{{ __('City') }}</th>
                                            <th scope="col">{{ __('Address') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($locations->isEmpty())
                                                <tr>
                                                    <td colspan="8" style="text-align: center">
                                                        <h3>No data available</h3>
                                                    </td>
                                                </tr>
                                        @else
                                            @foreach($locations as $location)
                                            <tr>
                                                    <td>{{ $location->location }}</td>
                                                    <td>{{ $location->country->name }}</td>
                                                    <td>{{ $location->state->name }}</td>
                                                    <td>{{ $location->city->name }}</td>
                                                    <td>{{ $location->address }}</td>
                                                    @if(getCreatedByDetails($location->user_type, $location->created_by) !== null)
                                                        <td>{{ getCreatedByDetails($location->user_type, $location->created_by)['name'] .' '.
                                                                getCreatedByDetails($location->user_type, $location->created_by)['last_name']
                                                            }}
                                                        </td>
                                                    @else
                                                        <td>Not Set</td>
                                                    @endif
                                            <td>   
                                                    <span>
                                                        <div class="col-4 text-right">
                                                            <a href="{{ route('sales.location.show', [$location->id]) }}" class="btn btn-sm btn-success" title="View"><i class="las la-eye"></i></a>
                                                            
                                                        </div>
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
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection