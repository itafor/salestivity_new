@extends('layouts.app', ['title' => __('Project Management'), 'icon' => 'las la-gem'])

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
                                <a href="{{ route('project.create') }}" class="btn-icon btn-tooltip" title="{{ __('Add Project') }}"><i class="las la-plus-circle"></i></a>
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
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Start Date') }}</th>
                                            <th scope="col">{{ __('End Date') }}</th>
                                            <th scope="col">{{ __('Author') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($projects->isEmpty())
                                                <tr>
                                                    <td colspan="8" style="text-align: center">
                                                        <h3>No data available</h3>
                                                    </td>
                                                </tr>
                                        @else
                                            @foreach($projects as $project)
                                                <tr>
                                                    <td>{{ $project->customer ? $project->customer->name : 'N/A' }}</td>
                                                    <td>{{ $project->product ? $project->product->name : 'N/A'}}</td>
                                                    <td>{{ $project->status ? $project->status : 'N/A' }}</td>
                                                    <td>{{ strftime('%d-%b-%Y', strtotime($project->start_date)) }}</td>
                                                    <td>{{ strftime('%d-%b-%Y', strtotime($project->end_date)) }}</td>
                                                    @if(getCreatedByDetails($project->user_type, $project->created_by) !== null)
                                                        <td>{{ getCreatedByDetails($project->user_type, $project->created_by)['name'] .' '.
                                                                getCreatedByDetails($project->user_type, $project->created_by)['last_name']
                                                            }}
                                                        </td>
                                                    @else
                                                        <td>Not Set</td>
                                                    @endif
                                                    <td>

                                                        <div class="btn-group-justified text-center" role="group">
                                                            <div class="btn-group" role="group">
                                                            <a href="{{ route('project.show', [$project->id]) }}" class="btn-icon btn-tooltip" title="View"><i class="las la-eye"></i></a>
                                                            </div>  

                                                            <div class="btn-group" role="group">
                                                         
                                                             <a onclick="return confirm('Do you really want to delete this item?');" href="{{ route('project.destroy', [$project->id]) }}" style="margin-right: 10px;" title="Delete" class="btn-icon btn-tooltip btn-sm btn-success" ><i class="las la-trash"></i></a>
                                                            </div>
                                                        </div>
                                                    </td>                                                    
                                                </tr>
                                            @endforeach
                                        @endif
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