@extends('layouts.app', ['title' => __('Team Management'), 'icon' => 'las la-suitcase'])
@section('content')
@include('users.partials.header', ['title' => __('All Teams')]) 

      
    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 mb-10">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All teams') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" class="btn-icon btn-tooltip" title="{{ __('Create Team') }}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                   <i class="las la-cart-plus"></i>
                                </a>
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
                        
                            
                                <table class="table table-bordered align-items-center table-flush datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">{{ __('Teams') }}</th>
                                            <th scope="col">{{ __('Members count') }}</th>
                                            <th scope="col">{{ __('Description') }}</th>
                                            <th scope="col" class="text-center">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($teams->isEmpty())
                                            <tr>
                                                <td colspan="8" style="text-align: center">
                                                    <h3>No data available</h3>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($teams as $team)
                                            <tr>
                                                <td>{{ $team->team_name }} </td>
                                                <td>{{count($team->members)}} members</td>
                                                <td>{{ $team->description }}</td>
                                                
                                                <td>
                                                    <div class="btn-group-justified text-center" role="group">

                                                        <div class="btn-group" role="group">
                                        <a onclick="addTeamMember({{$team->id}},'{{ $team->team_name }}')" href="#" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="Add member to {{$team->team_name}}" data-bs-toggle="modal" data-bs-target="#add_team_member_modal"><i class="las la-plus"></i></a>
                                                        </div>

                                                        <div class="btn-group" role="group">
                                                            <a onclick="editTeam({{$team->id}})" href="#" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="Edit" data-bs-toggle="modal" data-bs-target="#edit_team_modal"><i class="las la-edit"></i></a>
                                                        </div>
                                                         <div class="btn-group" role="group">
                                                            <a href="{{ route('team.show', [$team->id]) }}" style="margin-right: 10px;" class="btn-icon btn-tooltip" title="View"><i class="las la-eye"></i></a>
                                                        </div>  
                                                        <div class="btn-group" role="group">
                                                             <a onclick="return confirm('Do you really want to delete this team?');" href="{{route('team.destroy', [$team->id]) }}" class="btn-icon btn-tooltip" title="Delete"><i class="las la-trash-alt"></i></a>
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

        <!-- Button trigger modal -->


@include('teams.partials.create_team')
@include('teams.partials.edit_team')
@include('teams.partials.add_member')
            


    @include('layouts.footers.auth')
  </div>
  <script type="text/javascript" src="/js/team.js"></script>
@endsection