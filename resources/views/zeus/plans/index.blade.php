@extends('layouts.zeus_layout', ['title' => __('Plans Management')])
@section('content')
@include('zeus.partials.header', ['title' => __('All Plans')])
    <div class="container-fluid mt--7"> 
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('All Plans') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('admin.plans.create') }}" class="btn btn-sm btn-primary">{{ __('Add New Plan') }}</a>
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
                      <div class="table-responsive">

                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                          <th>S/N</th>
                          <th><b>Name</b></th>
                          <th><b>Price</b></th>
                          <th><b>Number of sub users</b></th>
                          <th><b>Number of accounts</b></th>
                          <th><b>Description</b></th>
                          <th class="text-center"><b>Action</b></th>
                      </tr>
                    </thead>
                    <tbody>
                        @if(isset($plans) && count($plans) >=1)
                    @php $i=1 @endphp
                    @foreach ($plans as $plan)
                      <tr>
                          <td>{{$i++}}</td>
                          <td>{{$plan->name}}</td>
                          <td>{{number_format($plan->amount, 2)}}</td>
                          <td>{{$plan->number_of_subusers}}</td>
                          <td>{{$plan->number_of_accounts}}</td>
                          <td>{{$plan->description}}</td>
                          <td class="text-center">
                                  <a class="btn btn-sm btn-success" href="{{route('admin.plans.edit', [$plan->id])}}">
                                      Edit
                                  </a>
                                 
                              
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