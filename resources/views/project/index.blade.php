@extends('layouts.app', ['title' => __('Project Management')])

@section('content')
@include('users.partials.header', ['title' => __('All Projects')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Projects') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.create') }}" class="btn btn-sm btn-primary">{{ __('Add Project') }}</a>
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
                                <table class="table table-bordered table-hover datatable align-items-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Customer') }}</th>
                                            <th scope="col">{{ __('Product') }}</th>
                                            <th scope="col">{{ __('Technician') }}</th>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __('Notes') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $project)
                                            <tr>
                                                <td>{{ $project->customer->name }}</td>
                                                <td>{{ $project->product->name }}</td>
                                                <td>{{ $project->technician }}</td>
                                                <td>{{ strftime('%d-%b-%Y', strtotime($project->start_date)) }}</td>
                                                <td>{{ strftime('%d-%b-%Y', strtotime($project->end_date)) }}</td>
                                                <td>{{ $project->notes }}</td>
                                                <td>
                                                    <div class="col-4 text-right">
                                                        <a href="{{ route('project.show', [$project->id]) }}" class="btn btn-sm btn-success">{{ __('View') }}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                <form action="{{ route('project.destroy', [$project->id]) }}" method="delete" onsubmit="return confirm('Do you really want to delete this item?');" >
                                                    @csrf
                                                    <div class="col-4 text-right">
                                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                    </div>
                                                </form>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- col-12 -->
                    </div><!-- card body -->
                    
                </div>
            </div>
        </div>
            


    @include('layouts.footers.auth')
  </div>
@endsection