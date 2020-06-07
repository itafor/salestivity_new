@extends('layouts.app', ['title' => __('Departments')])
@section('content')
@include('users.partials.header', ['title' => __('All Departments')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Departments') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('dept.create') }}" class="btn btn-sm btn-primary">{{ __('Add Department') }}</a>
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
                                <table class="table align-items-center table-flush" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Department Head') }}</th>
                                            <th scope="col">{{ __('Unit') }}</th>
                                            <th scope="col">{{ __('Unit Head') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($departments as $department)
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                <td>{{ $department->dept_head }}</td>
                                                <td>
                                                    @foreach($department->units as $unit)
                                                        {{ $unit->name }},
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($department->units as $unit)
                                                        @if(!empty($unit->head))
                                                            {{ $unit->head }},
                                                        @else
                                                            {{ $unit->head }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                
                                                <td>
                                                    <div class="col-4 text-right">
                                                
                                                        <a href="{{ route('dept.show', [$department->id]) }}" class="btn btn-sm btn-success">{{ __('Manage') }}</a>
                                                    </div>
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
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection