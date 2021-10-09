@extends('layouts.zeus_layout', ['title' => __('Subscription Management')])
@section('content')
@include('zeus.partials.header', ['title' => __('All Subscription')])
    <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Subscription') }}</h3>
                            </div>
                            <!-- <div class="col-4 text-right">
                                <a href="{{route('admin.plans.create') }}" class="btn btn-sm btn-primary">{{ __('Add New Plan') }}</a>
                            </div> -->
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

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th><b>User</b></th>
                          <th><b>Plan</b></th>
                          <!-- <th><b>Name</b></th> -->
                          <th><b>Price</b></th>
                          <th><b>Users</b></th>
                          <th><b>Accounts</b></th>
                          <th><b>Status</b></th>
                          <th><b>Start Date</b></th>
                          <th><b>End Date</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                        @if(isset($subscriptions) && count($subscriptions) >=1)
                    @foreach ($subscriptions as $sub)
                      <tr>
                          <td>{{$sub->user ? $sub->user->name.' '.$sub->user->last_name : "N/A"}}</td>
                          <td>{{$sub->plan ? $sub->plan->name : "N/A"}}</td>
                          <td>{{number_format($sub->plan->amount, 2)}}</td>
                          <td>{{$sub->plan->number_of_subusers}}</td>
                          <td>{{$sub->plan->number_of_accounts}}</td>
                          <td>{{$sub->status}}</td>
                          <td>
                            {{ $sub->start_date ? date('d/m/Y', strtotime($sub->start_date)) : 'N/A' }}
                          </td>
                           <td>
                            {{ $sub->end_date ? date('d/m/Y', strtotime($sub->end_date)) : 'N/A' }}
                          </td>
                          <td class="text-center">
                            @if($sub->status == "Active")
                                  <a onclick="revokeSubscription({{$sub->user->id}}, {{$sub->plan->id}}, {{$sub->id}})" class="btn btn-sm bg-yellow" href="#">
                                      Revoke
                                  </a>
                                 @elseif($sub->status == "Pending")
                                  <a onclick="activateSubscription({{$sub->user->id}}, {{$sub->plan->id}}, {{$sub->id}})" class="btn btn-sm btn-success" href="#">
                                      Activate
                                  </a>
                                 @endif
                              
                          </td>
                      </tr>
                      @endforeach
                      @else
                      <span>No plans found</span>
                      @endif
                    </tbody>
                  </table>

                </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>



<script type="text/javascript">

  function revokeSubscription(userId, planId, subId) {
    swal({
        title: "Revoke Selected subscription",
        text: "Do you really want to revoke the selected subscription? This action will revoke the selected subscription and activate the Starter(Free) plan since a user must have at least on active plan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: baseUrl + "/admin/revoke/sub/" + userId + "/" + planId + "/"+subId,
                type: "GET",
                data: { userId: userId },
                success: function (data) {
                    console.log(data);
                    swal("Poof! The selected subscription has been revoked!", {
                        icon: "success",
                    });
                    location.reload();
                },
            });
        } else {
            swal("Action cancelled!");
        }
    });
}
    // Delete data with ajax
function activateSubscription(userId, planId, subId) {
    swal({
        title: "Activate Selected subscription",
        text: "Do you really want to activate the selected subscription?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: baseUrl + "/admin/activate/" + userId + "/" + planId + "/"+subId,
                type: "GET",
                data: { userId: userId },
                success: function (data) {
                  
                    swal("Poof! The selected subscription has been activated!", {
                        icon: "success",
                    });
                    location.reload();
                },
            });
        } else {
            swal("Action cancelled!");
        }
    });
}



</script>
@endsection