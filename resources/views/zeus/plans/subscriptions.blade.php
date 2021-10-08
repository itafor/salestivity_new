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
                          <td class="text-center">
                            @if($sub->status == "Active")
                                  <a class="btn btn-sm bg-yellow" href="{{route('admin.plans.edit', [$sub->id])}}">
                                      Revoke
                                  </a>
                                 @elseif($sub->status == "Pending")
                                  <a class="btn btn-sm btn-success" href="{{route('admin.plans.edit', [$sub->id])}}">
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

@endsection