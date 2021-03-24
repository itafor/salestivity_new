@extends('layouts.app', ['title' => __('City Management'), 'icon' => 'las la-layer-group'])

@section('content')
@include('users.partials.header', ['title' => __('All Cities')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Cities') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('location.create.city') }}" class="btn-icon btn-tooltip" title="{{ __('Add City') }}"><i class="las la-plus-circle"></i></a>
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
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('State') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(getCities()->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach(getCities()->take(10) as $city)
                                            <tr>
                                                <td>{{ $city->name }}</td>
                                                <td>{{ $city->state ? $city->state->name : 'N/A'  }}</td>
                                                
                                              
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('location.edit.city', [$city->id]) }}" style="margin-right: 10px;" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                        </div>  

                                                        <div class="btn-group" role="group">
                                                            <form action="{{ route('location.destroy.city', [$city->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                                @csrf
                                                                <button type="submit" style="margin-right: 10px;" class="btn btn-sm btn-danger" title="Delete"><i class="las la-trash-alt"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
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