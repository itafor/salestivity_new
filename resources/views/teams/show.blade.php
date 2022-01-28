@extends('layouts.app', ['title' => __('Team Management'), 'icon' => 'las la-cart'])

@section('content')
@include('users.partials.header', ['title' => __('Team')]) 


<div class="container-fluid mt--7">
        <div class="row">
<div class="col-xl-12 order-xl-1">
  <div class="card shadow">
  

    <div class="card-header bg-white">
      <div class="row align-items-center">
          <div class="col-8">
              <h3 class="mb-0">{{ __('Team Details') }}</h3>
          </div>
          <div class="col-4 text-right">
              <a onclick="editTeam({{$team->id}})" href="#" class="btn-icon btn-tooltip" title="{{ __('Edit') }}" data-bs-toggle="modal" data-bs-target="#edit_team_modal"><i class="las la-edit"></i></a>
              <a href="{{ route('team.index') }}" class="btn-icon btn-tooltip" title="{{ __('Back To List') }}"><i class="las la-angle-double-left"></i></a>
          </div>
      </div>
    </div>





  <div class="card-body">
             <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($team))
                    <tbody>
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Team') }}</b></td>
                     <td>{{$team->team_name}}</td>
                   </tr>
                    <tr>
                     <td style="width: 200px;"><b>{{ __('Description') }}</b></td>
                     <td>{{$team->description}}</td>
                   </tr>
                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table> 
  </div>
</div>



  <div class="card ">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Members') }} ({{count($team_members)}})</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a onclick="addTeamMember({{$team->id}},'{{ $team->team_name }}')" href="#" class="btn-icon btn-tooltip" title="Add member to {{$team->team_name}}" data-bs-toggle="modal" data-bs-target="#add_team_member_modal"><i class="las la-plus-circle"></i></a>
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

                     <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('Email') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($team_members) <=0)
                                        <tr>
                                            <td colspan="8" style="text-align: center">
                                                <h3>No data available</h3>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($team_members as $member)
                                            <tr>
                                                <td>{{ $member->getMember ? $member->getMember->name : 'N/A' }} {{ $member->getMember ? $member->getMember->last_name : 'N/A' }}</td>
                                                <td>
                                                    <a href="mailto:{{ $member->email }}">{{ $member->getMember ? $member->getMember->email : 'N/A' }}</a>
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
        
        @include('layouts.footers.auth')
        @include('teams.partials.edit_team')
@include('teams.partials.add_member')


    </div>
  <script type="text/javascript" src="/js/team.js"></script>
  <script type="text/javascript" src="/js/team.js"></script>
  

@endsection