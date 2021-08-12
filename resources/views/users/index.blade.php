@extends('layouts.app', ['title' => __('User Management'), 'icon' => 'las la-users-cog'])
@section('content')
@include('users.partials.header', ['title' => __('All Users')])


    <div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Users') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('newSubUser') }}" class="btn-icon btn-tooltip" title="{{ __('Add User') }}"><i class="las la-plus-circle"></i></a>
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
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Role') }}</th>
                                        <th scope="col">{{ __('Author') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allusers->isEmpty())
                                        <tr>
                                            <td colspan="8" style="text-align: center">
                                                <h3>No data available</h3>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($allusers as $user)
                                            <tr>
                                                <td>{{ $user->name }} {{ $user->last_name }}</td>
                                                <td>
                                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                </td>
                                                <td style="color : {{ $user->status === 1 || $user->status === null ? 'green' : 'red' }}">
                                                    {{ ($user->status == 1 || $user->status === null) ? 'Enabled' : 'Disabled' }}
                                                </td>
                                                @if(isset($user->roles))
                                                    <td>{{ $user->roles->name }}</td>
                                                @else
                                                    <td>No role Selected</td>
                                                @endif
                                                @if(getCreatedByDetails($user->user_type, $user->created_by) !== null)
                                                    <td>{{ getCreatedByDetails($user->user_type, $user->created_by)['name'] .' '.
                                                            getCreatedByDetails($user->user_type, $user->created_by)['last_name']
                                                        }}
                                                    </td>
                                                @else
                                                    <td>Not Set</td>
                                                @endif
                                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            @if ($user->id != auth()->id())
                                                            <a class="dropdown-item" href="{{ route('editSubUser', $user) }}">{{ __('Edit') }}</a>
                                                                <form action="{{ route('deleteSubUSer', [encrypt($user->id)]) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    
                                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                                        {{ __('Delete') }}
                                                                    </button>
                                                                </form>    
                                                            @else
                                                               
                                                                <a class="dropdown-item" href="{{ route('editSubUser', $user) }}">{{ __('Edit') }}</a>

                                                                 <!-- <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Edit') }}</a> -->
                                                                 
                                                            @endif

                                                            @if($user->status == 1)
                                                             <a onclick="disableSubuser({{$user->status}}, {{$user->id}})" class="dropdown-item" href="#">{{ __('Disable user') }}
                                                                  </a>
                                                            @elseif($user->status == 0)
                                                                    <a onclick="enableSubuser({{$user->status}}, {{$user->id}})" class="dropdown-item" href="#">{{ __('Enable user') }}
                                                                  </a>
                                                             @endif

                                                                   
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav class="d-flex justify-content-end" aria-label="...">
                                {{ $allusers->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @include('layouts.footers.auth')
    </div>
@endsection

<script type="text/javascript">
    // Delete data with ajax
function enableSubuser(status, userId) {
    swal({
        title: "Enable Selected subuser",
        text: "Do you really want to enable the selected subuser?!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: baseUrl + "/update-subuser/" + status + "/" + userId,
                type: "GET",
                data: { userId: userId },
                success: function (data) {
                    swal("Poof! The selected subuser has been enabled!", {
                        icon: "success",
                    });
                    window.location.href = window.location.href; // refresh page
                },
            });
        } else {
            swal("Action cancelled!");
        }
    });
}

function disableSubuser(status, userId) {
    swal({
        title: "Enable Selected subuser",
        text: "Do you really want to enable the selected subuser?!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: baseUrl + "/update-subuser/" + status + "/" + userId,
                type: "GET",
                data: { userId: userId },
                success: function (data) {
                    console.log(data);
                    swal("Poof! The selected subuser has been disabled!", {
                        icon: "success",
                    });
                    window.location.href = window.location.href; // refresh page
                },
            });
        } else {
            swal("Action cancelled!");
        }
    });
}

</script>